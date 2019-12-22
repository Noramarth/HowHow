<?php

declare(strict_types=1);

namespace App\Service\Response;

use App\lib\ClassTools;
use App\lib\DoctrineRedisCache;
use App\lib\ORMClassTools;
use Doctrine\Common\Cache\RedisCache;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use stdClass;

class Mapper
{
    public bool $empty = false;
    public bool $multiple = false;

    private array $parents = [];

    private RedisCache $cache;

    private bool $forceCache;

    private bool $useCache;

    public function __construct()
    {
        $this->cache = DoctrineRedisCache::getCache();
    }

    public function map(array $items, ?int $depth = null, bool $useCache = true, bool $forceCache = false)
    {
        $this->useCache = $useCache;
        $this->forceCache = $forceCache;
        if ($useCache) {
            $cacheKey = DoctrineRedisCache::getCacheKey($this, __METHOD__, func_get_args());
            if ($forceCache) {
                $result = $this->runAllNoCache($items, $depth);
                $this->cache->save($cacheKey, $result, DoctrineRedisCache::CACHE_EXPIRATION_TIME);
                return $result;
            }
            $result = $this->cache->fetch($cacheKey);
            if ($result !== false) {
                return $result;
            }
            $result = $this->runAllNoCache($items, $depth);
            $this->cache->save($cacheKey, $result, DoctrineRedisCache::CACHE_EXPIRATION_TIME);
            return $result;
        }
        return $this->runAllNoCache($items, $depth);
    }

    private function runAllNoCache(array $items, ?int $depth = null)
    {
        $response = new stdClass();
        $depth = $depth ?? 1;
        $itemCount = count($items);
        if ($itemCount > 1) {
            $this->multiple = true;
            $response = $this->makeMultipleItemResponse($items, $depth);
        }
        if ($itemCount === 1) {
            $response = $this->singleItemResponse(array_shift($items), $depth);
        }
        return $response;
    }

    private function makeMultipleItemResponse(array $items, int $depth)
    {
        $data = [];
        foreach ($items as $item) {
            $this->parents = [];
            $responseItem = $this->singleItemResponse($item, $depth);
            $data[] = $responseItem;
        }
        return $data;
    }

    private function singleItemResponse(
        $item,
        int $maxDepth,
        ?int $currentDepth = 0
    ): stdClass
    {
        if ($this->useCache) {
            $cacheKey = DoctrineRedisCache::getCacheKey($item, __METHOD__, func_get_args());
            if ($this->forceCache) {
                return $this->getFreshlyCachedResult($item, $maxDepth, $cacheKey, $currentDepth);
            }
            $cachedResult = $this->cache->fetch($cacheKey);
            if ($cachedResult !== false) {
                return $cachedResult;
            }
            return $this->getFreshlyCachedResult($item, $maxDepth, $cacheKey, $currentDepth);
        }
        return $this->makeSingleItemResponse($item, $maxDepth, $currentDepth);
    }

    private function getFreshlyCachedResult(
        $item,
        int $maxDepth,
        string $cacheKey,
        ?int $currentDepth = 0
    ): stdClass
    {
        $result = $this->makeSingleItemResponse($item, $maxDepth, $currentDepth);
        $this->cache->save($cacheKey, $result, DoctrineRedisCache::CACHE_EXPIRATION_TIME);
        return $result;
    }

    private function makeSingleItemResponse(
        $item,
        int $maxDepth,
        ?int $currentDepth = 0
    ): stdClass
    {
        $suffix = strtolower(ClassTools::getBaseClassName($item));
        if ($currentDepth === 0) {
            $response = $this->addScalarValues($item, $suffix);
        }
        if (!isset($response)) {
            $response = new stdClass();
            $response->$suffix = new stdClass();
        }
        $response->$suffix->id = $item->id;
        if ($maxDepth >= $currentDepth + 1) {
            $childFields = ORMClassTools::getCollectionFields(get_class($item));
            foreach ($childFields as $field) {
                $getter = 'get' . ucfirst($field);
                /** @var ArrayCollection $children */
                $children = $item->$getter();
                $hasChildren = !$children->isEmpty();
                $hasChildrenField = 'has' . ucfirst($field);
                $response->$suffix->$hasChildrenField = $hasChildren;
                if ($hasChildren) {
                    $response->$suffix->$field = $this->getChildren($field, $children, $maxDepth, $currentDepth);
                }
            }
            $this->updateParents($item);
        }
        return $response;
    }

    private function addScalarValues($item, string $suffix)
    {
        $response = new stdClass();
        $response->$suffix = new stdClass();
        foreach (ORMClassTools::getScalarFields(get_class($item)) as $property) {
            $response->$suffix->$property = $item->$property;
        }
        return $response;
    }

    private function getChildren(string $parentField, Collection $children, int $maxDepth, int $currentDepth): array
    {
        $responses = [];
        $currentDepth++;
        foreach ($children as $child) {
            $childResponse = $this->makeSingleItemResponse(
                $child,
                $maxDepth,
                $currentDepth
            );
            $fieldName = substr($parentField, 0, -1);
            $response = new stdClass();
            $response->$fieldName = $childResponse->$fieldName;
            $responses[] = $response;
        }
        return $responses;
    }

    private function updateParents($item): void
    {
        $this->parents[] = get_class($item);
        $this->parents = array_unique($this->parents);
    }
}
