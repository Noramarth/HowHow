<?php

namespace App\Repository;

use App\Entity\NewBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NewBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewBook[]    findAll()
 * @method NewBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewBook::class);
    }

    // /**
    //  * @return NewBook[] Returns an array of NewBook objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewBook
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
