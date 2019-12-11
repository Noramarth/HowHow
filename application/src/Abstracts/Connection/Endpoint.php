<?php

declare(strict_types=1);

namespace App\Abstracts\Connection;

use App\Exception\InvalidEntitySetter;
use App\Exception\InvalidPropertyProvided;
use App\Interfaces\Entity;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;

abstract class Endpoint
{
    protected string $entity;

    private array $methods;

    private array $getters;

    private array $setters;

    /**
     * @param Request $request
     * @return bool
     * @throws InvalidPropertyProvided
     * @throws ReflectionException
     */
    public function supports(Request $request): bool
    {
        $body = json_decode($request->getContent());
        foreach ($body as $property => $value) {
            if (array_search($property, $this->getAllEntityProperties()) === false) {
                throw new InvalidPropertyProvided("{$this->entity} does not contain {$property}");
            }
            $valueType = 'integer' === gettype($value) ? 'int' : gettype($value);
            $propertyType = (new ReflectionClass($this->entity))->getProperty($property)->getType()->getName();
            if ($valueType !== $propertyType) {
                return false;
            }
        }
        return true;
    }

    private function getAllEntityProperties(): array
    {
        $publicProperties = get_class_vars($this->entity);

        $getterProperties = array_map(static function (string $getter) {
            return lcfirst(str_replace('get', '', $getter));
        }, $this->getGetters());
        $properties = array_merge($publicProperties, $getterProperties);
        return array_unique($properties);
    }

    private function getGetters()
    {
        if (empty($this->getters)) {
            $methods = get_class_methods($this->entity);
            $getters = array_filter($methods, static function ($method) {
                return strstr($method, 'get') !== false;
            });
            $this->getters = $getters;
        }
        return $this->getters;
    }

    protected function mapToObject(Request $request): Entity
    {
        $entity = new $this->entity;
        $body = json_decode($request->getContent());
        foreach ($body as $property => $value) {
            $setter = 'set' . ucfirst($property);
            if (array_search($setter, $this->getSetters()) === false) {
                throw new InvalidEntitySetter("{$setter} is not a real setter");
            }
            $entity->$setter($value);
        }
        return $entity;
    }

    private function getSetters()
    {
        if (empty($this->setters)) {
            $methods = get_class_methods($this->entity);
            $setters = array_filter($methods, static function ($method) {
                return strstr($method, 'set') !== false;
            });
            $this->setters = $setters;
        }
        return $this->setters;
    }
}
