<?php

namespace App\Repository;

use App\Entity\PasswordRecoveryRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PasswordRecoveryRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method PasswordRecoveryRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method PasswordRecoveryRequest[]    findAll()
 * @method PasswordRecoveryRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PasswordRecoveryRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PasswordRecoveryRequest::class);
    }

    // /**
    //  * @return PasswordRecoveryRequest[] Returns an array of PasswordRecoveryRequest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PasswordRecoveryRequest
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
