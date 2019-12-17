<?php

namespace App\Entity\Storage\Database\MySQL;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Chapter.
 *
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

    public function setChapterId(int $chapterId): Chapter
    {
        $this->chapterId = $chapterId;

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
}
