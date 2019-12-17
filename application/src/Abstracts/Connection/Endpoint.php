<?php

declare(strict_types=1);

namespace App\Abstracts\Connection;

use App\Exception\InvalidPropertyProvided;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;

abstract class Endpoint
{
    protected string $entity;

    private array $getters;

    private array $setters;

    /**
     * @throws InvalidPropertyProvided
     * @throws ReflectionException
     */
    public function supports(Request $request): bool
    {
        $body = json_decode($request->getContent());
        foreach ($body as $property => $value) {
            if (false === array_search($property, $this->getAllEntityProperties())) {
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
                return false !== strstr($method, 'get');
            });
            $this->getters = $getters;
        }

        return $this->getters;
    }

    private function getSetters()
    {
        if (empty($this->setters)) {
            $methods = get_class_methods($this->entity);
            $setters = array_filter($methods, static function ($method) {
                return false !== strstr($method, 'set');
            });
            $this->setters = $setters;
        }

        return $this->setters;
    }
}
