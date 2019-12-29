<?php

declare(strict_types=1);

namespace App\Endpoint\Book;

use App\DataManager\Reader\Book as Reader;
use App\Exception\UnexpectedPayloadForEndpoint;
use App\lib\Abstracts\Connection\Endpoint;
use App\lib\Interfaces\Endpoint as EndpointInterface;
use App\Service\Response\Mapper\Book;
use Symfony\Component\HttpFoundation\RequestStack;

class GetAll extends Endpoint implements EndpointInterface
{
    protected const DOMAIN = 'book';
    protected const METHOD = 'getAll';

    private RequestStack $request;
    private Reader $reader;
    private Book $mapper;

    public function __construct(RequestStack $requestStack, Reader $reader, Book $mapper)
    {
        $this->request = $requestStack;
        $this->reader = $reader;
        $this->mapper = $mapper;
    }

    public function handle()
    {
        $request = $this->request->getCurrentRequest();
        $payload = json_decode($request->getContent());
        $depth = isset($payload->depth) ? $payload->depth : null;
        if (null !== $payload && null === $depth) {
            throw new UnexpectedPayloadForEndpoint();
        }

        return $this->mapper->map($this->reader->findAll(), $depth);
    }
}
