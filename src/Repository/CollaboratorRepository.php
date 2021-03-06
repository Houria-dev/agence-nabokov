<?php

namespace App\Repository;

use App\Entity\Collaborator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Collaborator|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaborator|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaborator[]    findAll()
 * @method Collaborator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collaborator::class);
    }

    // /**
    //  * @return Collaborator[] Returns an array of Collaborator objects
    //  */
    
    public function findAllOrdredByName()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.lastname', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findCollaborator($nom, $prenom): ?Collaborator
    {
        return $this->createQueryBuilder('c')
        ->andWhere('c.firstname = :val')
        ->setParameter('val', $prenom)
        ->andWhere('c.lastname = :val2')
        ->setParameter('val2', $nom)
        ->getQuery()
        ->getOneOrNullResult()
        ;
    }
    /*
    public function findOneBySomeField($value): ?Collaborator
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
