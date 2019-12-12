<?php

declare(strict_types=1);

namespace App\Interfaces;


use Symfony\Component\HttpFoundation\Request;

interface Endpoint
{
    /**
     * @return SerializableResponse|null
     */
    public function handle(): ?SerializableResponse;
}