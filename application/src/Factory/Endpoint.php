<?php

namespace App\Factory;

use App\Constant\Connection;
use App\Exception\EndpointNotFound;
use App\Interfaces\Endpoint as EndpointInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Throwable;

class Endpoint
{
    private const ENDPOINT_BASE_NAMESPACE = 'App\\Endpoint';
    private const NAMESPACE_DIVIDER = '\\';

    public static function get(RequestStack $requestStack): EndpointInterface
    {
        $request = $requestStack->getCurrentRequest();
        $endpointClass = self::ENDPOINT_BASE_NAMESPACE;
        $endpointClass .= self::NAMESPACE_DIVIDER . ucfirst($request->headers->get(Connection::DOMAIN_HEADER));
        $endpointClass .= self::NAMESPACE_DIVIDER . ucfirst($request->headers->get(Connection::METHOD_HEADER));
        /* @var  EndpointInterface $service */
        try {
            return new $endpointClass($request);
        } catch (Throwable $exception) {
            throw new EndpointNotFound();
        }
    }
}
