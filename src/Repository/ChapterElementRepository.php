<?php

namespace App\Repository;

use App\Entity\ChapterElement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChapterElement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChapterElement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChapterElement[]    findAll()
 * @method ChapterElement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChapterElementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChapterElement::class);
    }

    // /**
    //  * @return ChapterElement[] Returns an array of ChapterElement objects
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
    public function findOneBySomeField($value): ?ChapterElement
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
