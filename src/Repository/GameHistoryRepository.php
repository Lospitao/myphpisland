<?php

namespace App\Repository;

use App\Entity\GameHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GameHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameHistory[]    findAll()
 * @method GameHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameHistory::class);
    }

    // /**
    //  * @return GameHistory[] Returns an array of GameHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameHistory
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
