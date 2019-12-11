<?php


namespace App\Entity\Storage\Database\MySQL;


class Chapter
{
    private int $chapterId;
    private int $bookId;
    private string $title;
    private string $body;

    /**
     * @return int
     */
    public function getChapterId(): int
    {
        return $this->chapterId;
    }

    /**
     * @param int $chapterId
     * @return Chapter
     */
    public function setChapterId(int $chapterId): Chapter
    {
        $this->chapterId = $chapterId;
        return $this;
    }

    /**
     * @return int
     */
    public function getBookId(): int
    {
        return $this->bookId;
    }

    /**
     * @param int $bookId
     * @return Chapter
     */
    public function setBookId(int $bookId): Chapter
    {
        $this->bookId = $bookId;
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
     * @return Chapter
     */
    public function setTitle(string $title): Chapter
    {
        $this->title = $title;
        return $this;
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
     * @return Chapter
     */
    public function setBody(string $body): Chapter
    {
        $this->body = $body;
        return $this;
    }
}
