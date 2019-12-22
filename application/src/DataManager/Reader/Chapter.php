<?php

declare(strict_types=1);

namespace App\DataManager\Reader;

use App\Entity\Storage\Database\MySQL\Chapter as ChapterEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class Chapter extends ServiceEntityRepository
{
    private const ENTITY = ChapterEntity::class;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, self::ENTITY);
    }
}