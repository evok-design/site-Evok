<?php

namespace App\Repository;

use App\Entity\PresseV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PresseV|null find($id, $lockMode = null, $lockVersion = null)
 * @method PresseV|null findOneBy(array $criteria, array $orderBy = null)
 * @method PresseV[]    findAll()
 * @method PresseV[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresseVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PresseV::class);
    }

    // /**
    //  * @return PresseV[] Returns an array of PresseV objects
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
    public function findOneBySomeField($value): ?PresseV
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
