<?php

declare(strict_types=1);

namespace App\Entity\Mapper;

use App\Entity\Storage\Database\MySQL\Book as BookEntity;
use App\lib\Interfaces\SerializableResponse;
use stdClass;

class Book implements SerializableResponse
{
    public bool $empty = false;
    public bool $multiple = false;
    /**
     * @var mixed
     */
    public $data;


    public function __construct(array $books)
    {
        $this->data = new stdClass();
        if (count($books) > 1) {
            $this->multiple = true;
            $this->makeMultipleItemResponse($books);
            return;
        }
        $id = $this->makeSingleItemResponse(array_shift($books), $this->data);
        if ($id === null) {
            $this->empty = true;
            return;
        }
        $this->data->id = $id;
    }

    private function makeMultipleItemResponse(array $books)
    {
        $this->data = [];
        foreach ($books as $book) {
            $responseItem = new stdClass();
            $id = $this->makeSingleItemResponse($book, $responseItem);
            $this->data[$id] = $responseItem;
        }
    }

    private function makeSingleItemResponse(?BookEntity $book, stdClass &$responseItem): ?int
    {
        if ($book === null) {
            return null;
        }
        $id = $book->getBookId();
        $responseItem->title = $book->getTitle();
        $responseItem->hasChapters = $book->hasChapters();
        $responseItem->chapters = $responseItem->hasChapters ? $book->getChapters() : null;
        $responseItem->body = $book->getBody();
        return $id;
    }
}