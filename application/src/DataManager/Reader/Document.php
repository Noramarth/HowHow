<?php

declare(strict_types=1);

namespace App\DataManager\Reader;

use App\Entity\Storage\Database\MySQL\Document as DocumentEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class Document extends ServiceEntityRepository
{
    private const ENTITY = DocumentEntity::class;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, self::ENTITY);
    }
}
