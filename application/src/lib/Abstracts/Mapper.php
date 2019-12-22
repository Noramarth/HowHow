<?php

declare(strict_types=1);

namespace App\lib\Abstracts;

use App\lib\ClassTools;
use App\lib\ORMClassTools;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use stdClass;

abstract class Mapper
{
    public bool $empty = false;
    public bool $multiple = false;

    /**
     * @var mixed
     */
    public $data;

    private array $parents = [];

    public function __construct(array $items, ?int $depth = null)
    {
        $depth = $depth ?? 1;
        $this->data = new stdClass();
        if (count($items) > 1) {
            $this->multiple = true;
            $this->makeMultipleItemResponse($items, $depth);
            return;
        }
        $response = $this->makeSingleItemResponse(array_shift($items), $depth);
        $this->data = $response;
    }

    private function makeMultipleItemResponse(array $items, int $depth)
    {
        $this->data = [];
        foreach ($items as $item) {
            $this->parents = [];
            $responseItem = $this->makeSingleItemResponse($item, $depth);
            $this->data[] = $responseItem;
        }
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
