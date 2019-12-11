<?php

declare(strict_types=1);

namespace App\Router;

use App\Constant\Connection;
use App\Exception\EndpointNotFound;
use Symfony\Component\HttpFoundation\Request;

class Endpoint
{
    /**
     * @param Request $request
     * @throws EndpointNotFound
     */
    public static function getEndpointFromRequest(Request $request)
    {
        $headers = $request->headers->get(Connection::ENDPOINT_HEADER);
        if (null === $headers) {
            throw new EndpointNotFound('No endpoint has been specified');
        }

    }
}