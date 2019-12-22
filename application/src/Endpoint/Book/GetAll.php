<?php

declare(strict_types=1);

namespace App\Endpoint\Book;

use App\Exception\UnexpectedPayloadForEndpoint;
use App\lib\Abstracts\Connection\Endpoint;
use App\DataManager\Reader\Book as Reader;
use App\lib\DoctrineRedisCache;
use App\lib\Interfaces\Endpoint as EndpointInterface;
use App\lib\Interfaces\SerializableResponse;
use App\Entity\Mapper;
use Doctrine\Common\Cache\RedisCache;
use Symfony\Component\HttpFoundation\RequestStack;
use Throwable;

class GetAll extends Endpoint implements EndpointInterface
{

    protected const DOMAIN = 'book';
    protected const METHOD = 'getAll';


    private RequestStack $request;
    private Reader $reader;
    private RedisCache $cache;

    public function __construct(RequestStack $requestStack, Reader $reader)
    {
        $this->request = $requestStack;
        $this->reader = $reader;
        $this->cache = DoctrineRedisCache::getCache();
    }

    public function handle(): ?SerializableResponse
    {
        $request = $this->request->getCurrentRequest();
        $payload = json_decode($request->getContent());
        $depth = isset($payload->depth) ? $payload->depth : null;
        if ($payload !== null && $depth === null) {
            throw new UnexpectedPayloadForEndpoint();
        }

        return new Mapper\Book($this->reader->findAll(), $depth, $this->cache);

    }
}
