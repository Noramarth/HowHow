<?php

declare(strict_types=1);

namespace App\Interfaces;

interface Endpoint
{
    public function handle(): ?SerializableResponse;
}
