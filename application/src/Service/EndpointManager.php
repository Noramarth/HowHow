<?php

declare(strict_types=1);

namespace App\Service;

use App\Constant\Connection;
use App\Exception\BadHeaders;
use App\Exception\EndpointNotFound;
use App\lib\Interfaces\Endpoint;
use Symfony\Component\HttpFoundation\RequestStack;

class EndpointManager
{
    public RequestStack $request;
    public iterable $endpoints;

    public function __construct(iterable $endpoints, RequestStack $requestStack)
    {
        $this->request = $requestStack;
        $this->endpoints = $endpoints;
    }

    /**
     * @throws EndpointNotFound
     * @throws BadHeaders
     */
    public function getEndpoint(): Endpoint
    {
        $domain = lcfirst($this->request->getCurrentRequest()->headers->get(Connection::DOMAIN_HEADER));
        $method = lcfirst($this->request->getCurrentRequest()->headers->get(Connection::METHOD_HEADER));
        if (null === $domain || null === $method) {
            throw new BadHeaders();
        }
        foreach ($this->endpoints as $endpoint) {
            if ($endpoint::supports($domain, $method)) {
                return $endpoint;
            }
        }

        throw new EndpointNotFound('Unable to find endpoint for domain ' . $domain . ' and method ' . $method);
    }
}
