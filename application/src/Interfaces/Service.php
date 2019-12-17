<?php

declare(strict_types=1);

namespace App\Interfaces;

use Symfony\Component\HttpFoundation\Request;

interface Service
{
    public function supports(Request $request): bool;

    public function handle(Request $request): ?SerializableResponse;
}
