<?php

namespace App\Entity\Storage\Database\MySQL;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Chapter.
 *
 * @ORM\Entity(
 *     repositoryClass="App\DataManager\Reader\Chapter"
 * )
 */
class Chapter
{
    /**
     * @ORM\Column(type="bigint")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public int $id;
    /**
     * @ORM\Column(type="string", nullable=true)
     */

    public ?string $title;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public ?string $body;

    /**
     * @ORM\OneToMany(targetEntity="Document", mappedBy="chapter", orphanRemoval=true)
     * @var Document[]|Collection
     */
    public ?Collection $documents;

    /**
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="chapters")
     */
    public ?Book $book;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    /**
     * @return Book
     */
    public function getBook(): Book
    {
        return $this->book;
    }

    /**
     * @param Book $book
     * @return Chapter
     */
    public function setBook(Book $book): Chapter
    {
        $this->book = $book;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): Chapter
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Chapter
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): Chapter
    {
        $this->body = $body;

        return $this;
    }

    public function addDocument(Document $document)
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setChapter($this);
        }
        return $this;
    }

    public function removeDocument(Document $document)
    {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
            $document->setChapter(null);
        }
        return $this;
    }

    public function getDocuments(): Collection
    {
        return $this->documents;
    }
}
