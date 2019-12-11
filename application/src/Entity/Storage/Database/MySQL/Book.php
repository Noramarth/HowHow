<?php

declare(strict_types=1);

namespace App\Entity\Storage\Database\MySQL;

use App\Interfaces\StorageEntity;

class Book implements StorageEntity
{
    private int $id;
    private string $title;
    /** @var Chapter[]|array */
    private array $chapters = [];
    private bool $hasChapters = false;
    private string $body = '';

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Book
     */
    public function setId(int $id): Book
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Book
     */
    public function setTitle(string $title): Book
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return Chapter[]|array
     */
    public function getChapters()
    {
        return $this->chapters;
    }

    /**
     * @param Chapter[]|array $chapters
     * @return Book
     */
    public function setChapters(array $chapters): Book
    {
        foreach ($chapters as $chapter) {
            $this->addChapter($chapter);
        }
        return $this;
    }

    /**
     * @param array $chapters
     * @return Book
     */
    public function removeChapters(array $chapters): Book
    {
        foreach ($chapters as $chapter) {
            $this->removeChapter($chapter);
        }
        return $this;
    }

    /**
     * @param Chapter $chapter
     * @return Book
     */
    public function addChapter(Chapter $chapter): Book
    {
        if (!array_key_exists($chapter->getTitle(), $this->chapters)) {
            $this->chapters[] = $chapter;
        }
        return $this;
    }

    /**
     * @param Chapter $chapter
     * @return Book
     */
    public function removeChapter(Chapter $chapter): Book
    {
        if (array_key_exists($chapter->getTitle(), $this->chapters)) {
            unset($this->chapters[$chapter->getTitle()]);
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function hasChapters(): bool
    {
        return $this->hasChapters;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return Book
     */
    public function setBody(string $body): Book
    {
        $this->body = $body;
        return $this;
    }

}