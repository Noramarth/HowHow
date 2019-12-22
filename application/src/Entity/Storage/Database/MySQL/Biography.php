<?php

declare(strict_types=1);

namespace App\Entity\Storage\Database\MySQL;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Biography.
 *
 * @ORM\Entity()
 */
class Biography
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     */
    public string $biographyId;

    /**
     * @ORM\Column(type="text")
     */
    public string $content;
}
