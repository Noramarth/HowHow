<?php

declare(strict_types=1);

namespace App\Endpoint\Book;

use App\DataManager\Reader\Book as Reader;
use App\Entity\Mapper;
use App\Exception\UnexpectedPayloadForEndpoint;
use App\lib\Abstracts\Connection\Endpoint;
use App\lib\Interfaces\Endpoint as EndpointInterface;
use App\lib\Interfaces\SerializableResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class GetById extends Endpoint implements EndpointInterface
{
    protected const DOMAIN = 'book';
    protected const METHOD = 'getById';

    private RequestStack $request;
    private Reader $reader;

    public function __construct(RequestStack $requestStack, Reader $reader)
    {
        $this->request = $requestStack;
        $this->reader = $reader;
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
        $data = [$this->reader->find($payload->id)];

        return new Mapper\Book($data);
    }
}
