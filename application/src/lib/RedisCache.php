<?php

declare(strict_types=1);

namespace App\lib;

use App\Constant\Common;

class RedisCache
{
    public const CACHE_EXPIRATION_TIME = 3600;

    public static function makeCacheKey($object, string $methodName, array $args): string
    {
        $key = ClassTools::getBaseClassName($object) .
            Common::CACHE_DELIMITER .
            ClassTools::getBaseMethodName($methodName);
        $argVals = MethodTools::getArgValues($args);
        if ('' !== $argVals) {
            $key .= Common::CACHE_DELIMITER . $argVals;
        }

        return $key;
    }
}
