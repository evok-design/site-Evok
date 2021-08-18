<?php

namespace App\Repository;

use App\Entity\PresseA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PresseA|null find($id, $lockMode = null, $lockVersion = null)
 * @method PresseA|null findOneBy(array $criteria, array $orderBy = null)
 * @method PresseA[]    findAll()
 * @method PresseA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresseARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PresseA::class);
    }

    // /**
    //  * @return PresseA[] Returns an array of PresseA objects
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
    public function findOneBySomeField($value): ?PresseA
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
