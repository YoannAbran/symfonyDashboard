<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */

  public function getSumBuyPrice()
  {
    return $this->createQueryBuilder('b')
    ->select('SUM(b.buyPrice) AS buyP, b.category, b.stock')
    ->groupBy('b.category')
    ->getQuery()
    ->getResult();
  }

  public function getSumSoldPrice()
  {
    return $this->createQueryBuilder('b')
    ->select('SUM(b.soldPrice) AS soldP, b.category, b.sold')
    ->groupBy('b.category')
    ->getQuery()
    ->getResult();
  }

  public function getSumRentPrice()
  {
    return $this->createQueryBuilder('b')
    ->select('SUM(b.rent) AS rentL, b.category,b.rent')
    ->groupBy('b.category')
    ->getQuery()
    ->getResult();
  }
}
