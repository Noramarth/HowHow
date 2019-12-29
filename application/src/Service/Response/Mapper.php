<?php

declare(strict_types=1);

namespace App\Service\Response;

use App\lib\ClassTools;
use App\lib\ORMClassTools;
use App\lib\RedisCache;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use stdClass;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class Mapper
{
    public bool $empty = false;
    private array $parents = [];
    private CacheInterface $cache;
    private bool $useCache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function map(array $items, ?int $depth = null, bool $useCache = true)
    {
        $this->useCache = $useCache;
        if ($useCache) {
            $cacheKey = RedisCache::makeCacheKey($this, __METHOD__, func_get_args());

            return $this->cache->get($cacheKey, function (ItemInterface $item) use ($items, $depth) {
                $data = $this->getFreshData($items, $depth);
                $item->set($data);
                $item->expiresAfter(RedisCache::CACHE_EXPIRATION_TIME);

                return $data;
            });
        }

        return $this->getFreshData($items, $depth);
    }

    private function getFreshData(array $items, ?int $depth = null)
    {
        $response = new stdClass();
        $depth = $depth ?? 1;
        $itemCount = count($items);
        if ($itemCount > 1) {
            return $this->makeMultipleItemResponse($items, $depth);
        }
        if (1 === $itemCount) {
            return $this->singleItemResponse(array_shift($items), $depth);
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
    ): stdClass {
        if ($this->useCache) {
            $cacheKey = RedisCache::makeCacheKey($item, __METHOD__, func_get_args());
            dump($this->cache);
            $test = $this->cache->get(
                $cacheKey,
                function (ItemInterface $cachedItem) use ($item, $maxDepth, $currentDepth, $cacheKey) {
                    $result = $this->makeSingleItemResponse($item, $maxDepth, $currentDepth);
                    dump($result);
                    ob_flush();
                    $cachedItem->set($result);
                    $cachedItem->expiresAfter(RedisCache::CACHE_EXPIRATION_TIME);

                    return $result;
                }
            );
            dump($test);
            ob_flush();

            return $test;
        }

        return $this->makeSingleItemResponse($item, $maxDepth, $currentDepth);
    }

    private function makeSingleItemResponse(
        $item,
        int $maxDepth,
        ?int $currentDepth = 0
    ): stdClass {
        $suffix = strtolower(ClassTools::getBaseClassName($item));
        if (0 === $currentDepth) {
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
        ++$currentDepth;
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
