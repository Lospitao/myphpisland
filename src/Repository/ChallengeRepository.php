<?php

namespace App\Repository;

use App\Entity\Kata;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Kata|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kata|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kata[]    findAll()
 * @method Kata[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kata::class);
    }

    // /**
    //  * @return Kata[] Returns an array of Kata objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Kata
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}