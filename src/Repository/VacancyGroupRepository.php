<?php

namespace App\Repository;

use App\Entity\VacancyGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VacancyGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method VacancyGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method VacancyGroup[]    findAll()
 * @method VacancyGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VacancyGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VacancyGroup::class);
    }

    // /**
    //  * @return VacancyGroup[] Returns an array of VacancyGroup objects
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
    public function findOneBySomeField($value): ?VacancyGroup
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
