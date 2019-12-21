<?php

declare(strict_types=1);

namespace App\lib\Abstracts\Connection;

use App\Exception\InvalidPropertyProvided;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;

abstract class Endpoint
{
    protected const DOMAIN = '';

    protected const METHOD = '';

    public static function supports(string $domain, string $method): bool
    {
        return ($domain === static::DOMAIN) && ($method === static::METHOD);
    }
}
