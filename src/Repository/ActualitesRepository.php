<?php

namespace App\Repository;

use App\Entity\Actualites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Actualites|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actualites|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actualites[]    findAll()
 * @method Actualites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualitesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Actualites::class);
    }

    // /**
    //  * @return Actualites[] Returns an array of Actualites objects
    //  */
    public function loadLastCreated($limit, $begin = 0)
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.date', 'DESC')
            ->setFirstResult($begin)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }

    public function lastCreated($limit, $begin = 0)
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.date', 'DESC')
            ->setFirstResult($begin)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }

    public function LoadByCalendar($date){
//        $date = date('Y-m-d', strtotime('first day of january this year'));

        return $this->createQueryBuilder('p')
            ->andWhere('p.date = :checkDate')
            ->setParameter('checkDate', $date)
            ->getQuery()
            ->getResult();
    }

    public function LoadBySearch($search){

        return $this->createQueryBuilder('s')
            ->where('s.contenu LIKE :search OR s.titre LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->getQuery()
            ->getResult();
    }

    public function loadByDateDesc(){
        return $this->createQueryBuilder('a')
            ->orderBy('a.date', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function loadByPage($page){
        $now = new \DateTime('now');
        return $this->createQueryBuilder('a')
            ->andWhere('a.date <= :now')
            ->setParameter('now', $now)
            ->orderBy('a.date', 'DESC')
            ->setMaxResults(12)
            ->setFirstResult($page*12)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


}
