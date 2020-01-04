<?php

declare(strict_types=1);

namespace App\lib\Abstracts\Mapper;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use stdClass;
use Symfony\Component\Cache\Adapter\NullAdapter;
use Symfony\Contracts\Cache\CacheInterface;

abstract class Base
{
    protected bool $useCache = true;
    protected CacheInterface $cache;
    private bool $recursive = false;
    private int $recursionsDepth = 0;
    private EntityManagerInterface $entityManager;

    public function __construct(CacheInterface $cache, EntityManagerInterface $_em)
    {
        $this->cache = $cache;
        $this->entityManager = $_em;
    }

    public function ignoreCache(): self
    {
        $this->useCache = false;
        $this->cache = new NullAdapter();
        return $this;
    }

    public function recursionsDepth(int $depth): self
    {
        $this->recursionsDepth = $depth;
        return $this;
    }

    public function parseMultiple(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            $result[] = $this->parseOne($item);
        }
        return $result;
    }

    public function parseOne(object $item, ?int $depth = null): stdClass
    {
        if ($depth === null) {
            $depth = $this->recursionsDepth;
        }
        $result = new stdClass();
        foreach (get_object_vars($item) as $property => $value) {
            if ($value instanceof Collection) {
                $result->$property = $this->getCollectionData($value, $depth);
                continue;
            }
            if (is_object($value) && $this->isORMEntity($value)) {
                $result->$property = $this->getEntityData($value, $depth);
                continue;
            }
            $result->$property = $value;
        }
        return $result;
    }

    private function getCollectionData(Collection $collection, $depth): array
    {
        if (!$this->recursive) {
            return $this->getChildCollectionIds($collection);
        }
    }

    private function getChildCollectionIds(Collection $collection): array
    {
        $results = [];
        foreach ($collection as $item) {
            if ($this->isORMEntity($item)) {
                $primaryKeys = $this->getORMEntityPrimaryKey($item);
                $results[] = $primaryKeys;
                continue;
            }
            if (property_exists($item, 'id')) {
                $resultObject = new stdClass();
                $resultObject->id = $item->id;
                $results[] = $resultObject;
                continue;
            }
            if (method_exists($item, 'getId')) {
                $resultObject = new stdClass();
                $resultObject->id = $item->getId();
                $results[] = $resultObject;
            }
        }
        return $results;
    }

    private function isORMEntity(object $item): bool
    {
        return $this->entityManager->getMetadataFactory()->hasMetadataFor(get_class($item));
    }

    private function getORMEntityPrimaryKey(object $entity): stdClass
    {
        $results = new stdClass();
        $metadata = $this->entityManager
            ->getClassMetadata(get_class($entity));
        $primaryKeyFields = $metadata->getIdentifierFieldNames();
        foreach ($primaryKeyFields as $primaryKeyField) {
            $results->$primaryKeyField = $entity->$primaryKeyField;

        }
        return $results;
    }

    private function getEntityData(object $entity, int $depth)
    {
        if (!$this->recursive) {
            return $this->getORMEntityPrimaryKey($entity);
        }
    }

    protected function setRecursive(): self
    {
        $this->recursive = true;
        return $this;
    }
}

