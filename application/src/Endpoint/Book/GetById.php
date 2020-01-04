<?php

declare(strict_types=1);

namespace App\Endpoint\Book;

use App\DataManager\Reader\Book as Reader;
use App\Entity\Mapper;
use App\Exception\UnexpectedPayloadForEndpoint;
use App\lib\Abstracts\Connection\Endpoint;
use App\lib\Interfaces\Endpoint as EndpointInterface;
use App\lib\Interfaces\SerializableResponse;
use App\Service\Response\Mapper\Book;
use Symfony\Component\HttpFoundation\RequestStack;

class GetById extends Endpoint implements EndpointInterface
{
    protected const DOMAIN = 'book';
    protected const METHOD = 'getById';

    private RequestStack $request;
    private Reader $reader;
    private Book $mapper;

    public function __construct(RequestStack $requestStack, Reader $reader, Book $mapper)
    {
        $this->request = $requestStack;
        $this->reader = $reader;
        $this->mapper = $mapper;
    }

    public function handle(): ?SerializableResponse
    {
        $currentRequest = $this->request->getCurrentRequest();
        $payload = json_decode($currentRequest->getContent());
        if (null === $payload) {
            throw new UnexpectedPayloadForEndpoint();
        }
        if (!isset($payload->id)) {
            throw new UnexpectedPayloadForEndpoint();
        }
        $data = $this->reader->find($payload->id);

        return $this->mapper->mapOne($data);
    }
}
