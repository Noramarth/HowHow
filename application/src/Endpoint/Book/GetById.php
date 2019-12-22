<?php

declare(strict_types=1);

namespace App\Endpoint\Book;

use App\Exception\UnexpectedPayloadForEndpoint;
use App\lib\Abstracts\Connection\Endpoint;
use App\DataManager\Reader\Book as Reader;
use App\lib\Interfaces\Endpoint as EndpointInterface;
use App\lib\Interfaces\SerializableResponse;
use App\Entity\Mapper;
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
        $request = $this->request->getCurrentRequest();
        $payload = json_decode($request->getContent());
        if ($payload === null) {
            throw new UnexpectedPayloadForEndpoint();
        }
        if (!isset($payload->id)) {
            throw new UnexpectedPayloadForEndpoint();
        }
        $data = [$this->reader->find($payload->id)];
        return new Mapper\Book($data);
    }
}
