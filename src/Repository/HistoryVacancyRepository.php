<?php

namespace App\Repository;

use App\Entity\HistoryVacancy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HistoryVacancy|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryVacancy|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryVacancy[]    findAll()
 * @method HistoryVacancy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryVacancyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryVacancy::class);
    }

    /**
     * @param $resume
     * @return ?HistoryVacancy
     */
    public function findByResume($resume): ?HistoryVacancy
    {
        try {
            return $this->createQueryBuilder('h')
                ->andWhere('h.resume_id = :val')
                ->setParameter('val', $resume)
                ->orderBy('h.date', 'DESC')
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException | NonUniqueResultException $e) {
            return null;
        }
    }
}
