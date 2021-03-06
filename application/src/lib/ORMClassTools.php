<?php

namespace App\lib;

use Doctrine\Common\Collections\Collection;
use ReflectionClass;

class ORMClassTools
{
    public static function getCollectionFields(string $className)
    {
        $class = new ReflectionClass($className);
        $properties = $class->getProperties();
        $result = [];
        foreach ($properties as $property) {
            $type = (string) $property->getType();
            if (Collection::class !== $type) {
                continue;
            }
            $result[] = $property->getName();
        }

        return $result;
    }

    public static function getScalarFields(string $className)
    {
        $class = new ReflectionClass($className);
        $properties = $class->getProperties();
        $result = [];
        foreach ($properties as $property) {
            $type = (string) $property->getType();
            if (Collection::class === $type) {
                continue;
            }
            $result[] = $property->getName();
        }

        return $result;
    }

    public static function getClassType(string $docBlock, string $entity): ?string
    {
        if (preg_match('/@var\s+([^\s]+)/', $docBlock, $matches)) {
            list(, $docType) = $matches;
            $type = strstr($docType, '[]', true);
            if (1 === count(explode('\\', $type))) {
                $namespaceParts = explode('\\', $entity);
                array_pop($namespaceParts);
                $type = implode('\\', $namespaceParts) . '\\' . $type;
            }

            return $type;
        }

        return null;
    }
}
