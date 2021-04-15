<?php

namespace App\Repository;

use App\Entity\VacancyHR;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VacancyHR|null find($id, $lockMode = null, $lockVersion = null)
 * @method VacancyHR|null findOneBy(array $criteria, array $orderBy = null)
 * @method VacancyHR[]    findAll()
 * @method VacancyHR[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VacancyHRRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VacancyHR::class);
    }

    // /**
    //  * @return VacancyHR[] Returns an array of VacancyHR objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VacancyHR
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
