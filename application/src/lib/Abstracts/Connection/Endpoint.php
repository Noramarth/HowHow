<?php

declare(strict_types=1);

namespace App\lib\Abstracts\Connection;

abstract class Endpoint
{
    protected const DOMAIN = '';

    protected const METHOD = '';

    public static function supports(string $domain, string $method): bool
    {
        return ($domain === static::DOMAIN) && ($method === static::METHOD);
    }
}
