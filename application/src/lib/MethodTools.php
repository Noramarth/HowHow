<?php

declare(strict_types=1);

namespace App\lib;

use App\Constant\Common;

class MethodTools
{
    public static function getArgValues(array $arguments): string
    {
        $result = '';
        $values = [];
        foreach ($arguments as $argument) {
            $values[] = self::getValue($argument);
        }
        if (!empty($values)) {
            $result = implode(Common::CACHE_DELIMITER, $values);
        }
        return $result;
    }

    private static function getValue($argument): ?string
    {
        if (is_object($argument)) {
            return self::getObjectValue($argument);
        }
        return self::getNonObjectValue($argument);
    }

    private static function getObjectValue(object $argument): ?string
    {
        if (method_exists($argument, 'getId')) {
            return (string)$argument->getId();
        }
        if (property_exists($argument, 'id')) {
            return (string)$argument->id;
        }
        return null;
    }

    private static function getNonObjectValue($argument)
    {
        if (is_scalar($argument)) {
            return (string)$argument;
        }
        if (is_array($argument) && !empty($argument)) {
            return 'Collection_' . hash('sha256', json_encode($argument));
        }
        return null;
    }
}
