<?php

declare(strict_types=1);

namespace App\Endpoint\Book;

use App\DataManager\Reader\Book as Reader;
use App\Exception\UnexpectedPayloadForEndpoint;
use App\lib\Abstracts\Connection\Endpoint;
use App\lib\DoctrineRedisCache;
use App\lib\Interfaces\Endpoint as EndpointInterface;
use App\Service\Response\Mapper\Book;
use Doctrine\Common\Cache\RedisCache;
use stdClass;
use Symfony\Component\HttpFoundation\RequestStack;

class GetAll extends Endpoint implements EndpointInterface
{

    protected const DOMAIN = 'book';
    protected const METHOD = 'getAll';


    private RequestStack $request;
    private Reader $reader;
    private RedisCache $cache;
    private Book $mapper;

    public function __construct(RequestStack $requestStack, Reader $reader, Book $mapper)
    {
        $this->request = $requestStack;
        $this->reader = $reader;
        $this->cache = DoctrineRedisCache::getCache();
        $this->mapper = $mapper;
    }

    public function handle()
    {
        $request = $this->request->getCurrentRequest();
        $payload = json_decode($request->getContent());
        $depth = isset($payload->depth) ? $payload->depth : null;
        if ($payload !== null && $depth === null) {
            throw new UnexpectedPayloadForEndpoint();
        }

        return $this->mapper->map($this->reader->findAll(), $depth);

    }
}
