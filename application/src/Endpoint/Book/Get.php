<?php

declare(strict_types=1);

namespace App\Endpoint\Book;

use App\Abstracts\Connection\Endpoint;
use App\Entity\Storage\Database\MySQL\Book;
use App\Interfaces\Endpoint as EndpointInterface;
use App\Interfaces\SerializableResponse;
use Symfony\Component\HttpFoundation\Request;

class Get extends Endpoint implements EndpointInterface
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->entity = Book::class;
        $this->request = $request;
    }

    /**
     * @return SerializableResponse|null
     */
    public function handle(): ?SerializableResponse
    {
        return null;
    }
}
