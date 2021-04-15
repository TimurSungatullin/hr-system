<?php

namespace App\Repository;

use App\Entity\ResumeToOwner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResumeToOwner|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResumeToOwner|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResumeToOwner[]    findAll()
 * @method ResumeToOwner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResumeToOwnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResumeToOwner::class);
    }

    // /**
    //  * @return ResumeToOwner[] Returns an array of ResumeToOwner objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResumeToOwner
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
