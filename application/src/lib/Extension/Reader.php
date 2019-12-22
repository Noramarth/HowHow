<?php

declare(strict_types=1);

namespace App\lib\Extension;

use App\lib\DoctrineRedisCache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Cache\RedisCache;
use Doctrine\Persistence\ManagerRegistry;

abstract class Reader extends ServiceEntityRepository
{
    protected RedisCache $cache;

    public function __construct(ManagerRegistry $registry, $entityClass)
    {

        $this->cache = DoctrineRedisCache::getCache();
        parent::__construct($registry, $entityClass);
    }

    public function findAll()
    {
        $cacheKey = DoctrineRedisCache::getCacheKey($this, __METHOD__, func_get_args());
        $result = $this->cache->fetch($cacheKey);
        if ($result === false) {
            $result = parent::findAll();
            $this->cache->save($cacheKey, $result, DoctrineRedisCache::CACHE_EXPIRATION_TIME);
        }
        return $result;
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        $cacheKey = DoctrineRedisCache::getCacheKey($this, __METHOD__, func_get_args());
        $result = $this->cache->fetch($cacheKey);
        if ($result === false) {
            $result = parent::find($id, $lockMode, $lockVersion);
            $this->cache->save($cacheKey, $result, DoctrineRedisCache::CACHE_EXPIRATION_TIME);
        }
        return $result;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $cacheKey = DoctrineRedisCache::getCacheKey($this, __METHOD__, func_get_args());
        $result = $this->cache->fetch($cacheKey);
        if ($result === false) {
            $result = parent::findBy($criteria, $orderBy, $limit, $offset);
            $this->cache->save($cacheKey, $result, DoctrineRedisCache::CACHE_EXPIRATION_TIME);
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $cacheKey = DoctrineRedisCache::getCacheKey($this, __METHOD__, func_get_args());
        $result = $this->cache->fetch($cacheKey);
        if ($result === false) {
            $result = parent::findOneBy($criteria, $orderBy);
            $this->cache->save($cacheKey, $result, DoctrineRedisCache::CACHE_EXPIRATION_TIME);
        }
        return $result;
    }
}
