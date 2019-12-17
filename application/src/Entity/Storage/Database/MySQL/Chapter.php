<?php

namespace App\Entity\Storage\Database\MySQL;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Chapter
 * @package App\Entity\Storage\Database\MySQL
 * @ORM\Entity()
 */
class Chapter
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     */
    public string $chapterId;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $title;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public ?string $body;

    public function getChapterId(): string
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
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Chapter
     */
    public function setTitle(?string $title): Chapter
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
     * @return Chapter
     */
    public function setBody(?string $body): Chapter
    {
        $this->body = $body;
        return $this;
    }
}
