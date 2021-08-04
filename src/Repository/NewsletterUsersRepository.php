<?php

namespace App\Repository;

use App\Entity\NewsletterUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NewsletterUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterUsers[]    findAll()
 * @method NewsletterUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterUsers::class);
    }

    // /**
    //  * @return NewsletterUsers[] Returns an array of NewsletterUsers objects
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
    public function findOneBySomeField($value): ?NewsletterUsers
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
