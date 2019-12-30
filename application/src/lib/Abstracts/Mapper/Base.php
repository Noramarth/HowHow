<?php

declare(strict_types=1);

namespace App\lib\Abstracts\Mapper;

use ReflectionClass;
use ReflectionException;
use stdClass;

abstract class Base
{
    protected bool $useCache = true;

    private array $parents = [];

    /**
     * @throws ReflectionException
     */
    public function mapObject(object $item)
    {
        $map = new stdClass();
        foreach ($this->getObjectValues($item) as $key => $value) {
            $map->$key = $value;
        }
        return $map;
    }

    /**
     * @throws ReflectionException
     */
    private function getObjectValues(object $item): array
    {
        $content = [];
        $reflectedObject = new ReflectionClass($item);
        $properties = $reflectedObject->getProperties();
        foreach ($properties as $property) {
            $key = $property->getName();
            $value = $property->getValue();
            if (is_object($value) && $this->isNotParent($value)) {
                $content[$key] = $value;
            }
        }
        return $content;
    }

    private function isNotParent(object $item): bool
    {
        return array_search(get_class($item), $this->parents) === false;
    }

    public function mapArray(array $item): stdClass
    {
        $map = new stdClass();
        foreach ($item as $key => $value) {
            $map->$key = $value;
        }
        return $map;
    }

    /**
     * @throws ReflectionException
     */
    public function mapArrayRecursive(array $item, ?int $depth = 1): stdClass
    {
        $map = new stdClass();
        foreach ($this->parseArrayRecursive($item, $depth) as $key => $value) {
            $map->$key = $value;
        }
        return $map;
    }

    /**
     * @throws ReflectionException
     */
    private function parseArrayRecursive(array $item, ?int $depth = 1): ?array
    {
        $content = [];
        if ($depth < 0) {
            return null;
        }
        foreach ($item as $key => $value) {
            $currentValue = $this->getCurrentValue($value, $depth);
            if (isset($currentValue) && $currentValue !== null) {
                $content[$key] = $currentValue;
            }
        }
        return $content;
    }

    /**
     * @param mixed $value
     * @param int|null $depth
     * @return mixed|null
     * @throws ReflectionException
     */
    private function getCurrentValue($value, ?int $depth = 1)
    {
        if (is_array($value)) {
            return $this->parseArrayRecursive($value, --$depth);
        }
        if (is_object($value)) {
            return $this->parseObjectRecursive($value, --$depth);
        }
        return $value;
    }

    /**
     * @throws ReflectionException
     */
    public function parseObjectRecursive(object $item, ?int $depth = 1): ?array
    {
        $content = [];
        if ($depth < 0) {
            return null;
        }
        $this->parents[] = get_class($item);
        foreach ($this->getObjectValues($item) as $key => $value) {
            $currentValue = $this->getCurrentValue($value, $depth);
            if (isset($currentValue) && $currentValue !== null) {
                $content[$key] = $currentValue;
            }
        }
        return $content;
    }

    /**
     * @throws ReflectionException
     */
    public function mapObjectRecursive(object $item, ?int $depth = 1)
    {
        $map = new stdClass();
        foreach ($this->parseObjectRecursive($item, $depth) as $key => $value) {
            $map->$key = $value;
        }
        return $map;
    }

    public function ignoreCache(): void
    {
        $this->useCache = false;
    }
}
