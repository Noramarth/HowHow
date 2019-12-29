<?php

namespace App\Entity\Storage\Database\MySQL;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Document.
 *
 * @ORM\Entity(repositoryClass="App\DataManager\Reader\Document")
 */
class Document
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
     * @ORM\ManyToOne(targetEntity="Chapter", inversedBy="documents")
     */
    public ?Chapter $chapter;

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Document
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Document
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): Document
    {
        $this->body = $body;

        return $this;
    }

    public function getChapter(): ?Chapter
    {
        return $this->chapter;
    }

    public function setChapter(?Chapter $chapter): Document
    {
        $this->chapter = $chapter;

        return $this;
    }
}
