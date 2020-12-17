<?php

namespace App\Repository;

use App\Entity\ChapterElementType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChapterElementType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChapterElementType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChapterElementType[]    findAll()
 * @method ChapterElementType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChapterElementTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChapterElementType::class);
    }

    // /**
    //  * @return ChapterElementType[] Returns an array of ChapterElementType objects
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
    public function findOneBySomeField($value): ?ChapterElementType
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
