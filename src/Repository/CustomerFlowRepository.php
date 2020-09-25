<?php

namespace App\Repository;

use App\Entity\CustomerFlow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CustomerFlow|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerFlow|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerFlow[]    findAll()
 * @method CustomerFlow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerFlowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerFlow::class);
    }

    // /**
    //  * @return CustomerFlow[] Returns an array of CustomerFlow objects
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
    public function findOneBySomeField($value): ?CustomerFlow
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
