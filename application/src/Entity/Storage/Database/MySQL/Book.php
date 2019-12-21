<?php

declare(strict_types=1);

namespace App\Entity\Storage\Database\MySQL;

use App\lib\Interfaces\StorageEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Class Book.
 *
 * @ORM\Entity()
 */
class Book implements StorageEntity
{
    /**
     * @ORM\Column(type="bigint")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    public int $bookId;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    public string $title;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Chapter",
     *     mappedBy="chapterId",
     *     cascade={
     *          "persist",
     *          "remove",
     *          "merge"
     *      },
     *     orphanRemoval=true
     * )
     *
     * @var Chapter[]|ArrayCollection|null
     */
    public $chapters;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public ?string $body;

    public function __construct()
    {
        $this->chapters = new ArrayCollection();
    }

    public function getBookId(): int
    {
        return $this->bookId;
    }

    public function setBookId(int $bookId): Book
    {
        $this->bookId = $bookId;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Book
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Chapter[]|ArrayCollection
     */
    public function getChapters()
    {
        return $this->chapters;
    }

    /**
     * @param Chapter[]|ArrayCollection $chapters
     * @return Book
     */
    public function setChapters($chapters): Book
    {
        $this->chapters = $chapters;

        return $this;
    }

    public function addChapter(Chapter $chapter): Book
    {
        if (!$this->chapters->contains($chapter)) {
            $this->chapters->add($chapter);
        }

        return $this;
    }

    public function removeChapter(Chapter $chapter): Book
    {
        if ($this->chapters->contains($chapter)) {
            $this->chapters->removeElement($chapter);
        }

        return $this;
    }

    public function hasChapters(): bool
    {
        return $this->chapters === null;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): Book
    {
        $this->body = $body;

        return $this;
    }
}
