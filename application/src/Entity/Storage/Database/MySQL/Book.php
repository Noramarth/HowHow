<?php

declare(strict_types=1);

namespace App\Entity\Storage\Database\MySQL;

use App\lib\Interfaces\StorageEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Book.
 *
 * @ORM\Entity(
 *     repositoryClass="App\DataManager\Reader\Book"
 * )
 */
class Book implements StorageEntity
{
    /**
     * @ORM\Column(type="bigint")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public int $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    public string $title;

    /**
     * @ORM\OneToMany(targetEntity="Chapter", mappedBy="book", orphanRemoval=true)
     *
     * @var Chapter[]|Collection
     */
    public Collection $chapters;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public ?string $body;


    public function __construct()
    {
        $this->chapters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): Book
    {
        $this->id = $id;

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
     * @return Chapter[]|Collection
     */
    public function getChapters(): Collection
    {
        return $this->chapters;
    }

    public function addChapter(Chapter $chapter): Book
    {
        if (!$this->chapters->contains($chapter)) {
            $this->chapters->add($chapter);
            $chapter->setBook($this);
        }

        return $this;
    }

    public function removeChapter(Chapter $chapter): Book
    {
        if ($this->chapters->contains($chapter)) {
            $this->chapters->removeElement($chapter);
            $chapter->setBook(null);
        }

        return $this;
    }

    public function hasChapters(): bool
    {
        return null === $this->getChapters();
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
