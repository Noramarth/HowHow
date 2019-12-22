<?php

declare(strict_types=1);

namespace App\lib;

use App\Constant\Common;
use Doctrine\Common\Cache\RedisCache;
use Redis;

class DoctrineRedisCache
{
    public const CACHE_EXPIRATION_TIME = 3600;

    public static function getCache(): RedisCache
    {
        $cache = new RedisCache();
        $redis = new Redis();
        $redis->connect($_ENV['REDIS_HOST'], intval($_ENV['REDIS_PORT']));
        $redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_IGBINARY);
        $cache->setRedis($redis);
        return $cache;
    }

    public static function getCacheKey($object, string $methodName, array $args): string
    {
        $key = ClassTools::getBaseClassName($object) .
            Common::CACHE_DELIMITER .
            ClassTools::getBaseMethodName($methodName);
        $argVals = MethodTools::getArgValues($args);
        if ($argVals !== '') {
            $key .= Common::CACHE_DELIMITER . $argVals;
        }
        return $key;
    }
}