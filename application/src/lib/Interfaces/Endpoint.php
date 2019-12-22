<?php

declare(strict_types=1);

namespace App\lib\Interfaces;

use React\Promise\FulfilledPromise;

interface Endpoint
{
    public static function supports(string $domain, string $method): bool;
    public function handle(): ?SerializableResponse;
}
