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
    
    public function findAllOrdredByDate()
    {
        return $this->createQueryBuilder('b')
            // ->andWhere('b.exampleField = :val')
            // ->setParameter('val', $value)
            ->orderBy('b.publication_date', 'DESC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllOrdredByDateAndLimited()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.publication_date', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
            ;
    }
    

    
    public function findBook($title,$editor,$publication): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.title = :val1')
            ->setParameter('val1', $title)
            ->andWhere('b.editor = :val2')
            ->setParameter('val2', $editor)
            ->andWhere('b.publication_date = :val3')
            ->setParameter('val3', $publication)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
