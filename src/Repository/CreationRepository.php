<?php

namespace App\Repository;

use App\Entity\Creation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Creation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Creation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Creation[]    findAll()
 * @method Creation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Creation::class);
    }

    // /**
    //  * @return Creation[] Returns an array of Creation objects
    //  */
//    public function findLastCreated($limit)
//    {
//        return $this->createQueryBuilder('c')
//            ->orderBy('c.id', 'DESC')
//            ->setMaxResults($limit)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findLastOrdre(){
        return $this->createQueryBuilder('c')
            ->select('c.ordre')
            ->orderBy('c.ordre', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    public function findAllOrderbyPrio(){
        return $this->createQueryBuilder('c')
            ->orderBy('c.id','desc')
            ->orderBy('c.ordre', 'asc' )
            ->getQuery()
            ->getResult()
            ;
    }

    public function findLastCreated($limit)
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.ordre', 'asc' )
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }

    public function loadLastCreated($limit, $begin = 0)
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.ordre', 'asc')
            ->setFirstResult($begin)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getRelated($exclude){
        return $this->createQueryBuilder('c')
            ->where('c.id != :id')
            ->setParameter('id', $exclude)
            ->getQuery()
            ->getResult();
    }

    public function getRelatedCategories($bloc){

        return $this->createQueryBuilder('c')
            ->innerJoin('c.Categorie', 'cat')
            ->where('cat.id IN (:bloc)')
            ->setParameter('bloc', $bloc)
            ->select(['c.id, c.slug, c.image_content'])
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();

    }

    /*
    public function findOneBySomeField($value): ?Creation
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
