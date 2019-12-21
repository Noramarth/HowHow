<?php

declare(strict_types=1);

namespace App\DataManager\Reader;

use App\Entity\Storage\Database\MySQL\Book as BookEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class Book extends ServiceEntityRepository
{
    private const ENTITY = BookEntity::class;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, self::ENTITY);
    }

}
