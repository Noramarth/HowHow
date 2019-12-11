<?php

declare(strict_types=1);

namespace App\Endpoint\Book;

use App\Abstracts\Connection\Endpoint;
use App\Entity\Storage\Database\MySQL\Book;
use App\Exception\InvalidEntitySetter;
use App\Interfaces\SerializableResponse;
use App\Interfaces\Service;
use Symfony\Component\HttpFoundation\Request;

class Get extends Endpoint implements Service
{
    public function __construct()
    {
        $this->entity = Book::class;
    }

    /**
     * @param Request $request
     * @return SerializableResponse|null
     * @throws InvalidEntitySetter
     */
    public function handle(Request $request): ?SerializableResponse
    {
        return null;
    }
}
