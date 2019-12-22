<?php


namespace App\Entity\Storage\Database\MySQL;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Document
 * @package App\Entity\Storage\Database\MySQL
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
     * @return Document
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Document
     */
    public function setTitle(?string $title): Document
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     * @return Document
     */
    public function setBody(?string $body): Document
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return Chapter|null
     */
    public function getChapter(): ?Chapter
    {
        return $this->chapter;
    }

    /**
     * @param Chapter|null $chapter
     * @return Document
     */
    public function setChapter(?Chapter $chapter): Document
    {
        $this->chapter = $chapter;
        return $this;
    }
}
