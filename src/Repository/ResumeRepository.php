<?php

namespace App\Repository;

use App\Entity\Resume;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Resume|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resume|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resume[]    findAll()
 * @method Resume[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResumeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resume::class);
    }

    /**
     * @param array $criteria
     * @param null $start
     * @param null $end
     * @param null $vacancy
     * @return Resume[] Returns an array of Resume objects
     */
    public function findByRangeDate(array $criteria, $start = null, $end = null): array
    {
        $builder = $this->createQueryBuilder('r');
        foreach ($criteria as $field => $value) {
            $builder = $builder
                -> andWhere('r.'.$field.' = :'.$field.'val')
                -> setParameter($field.'val', $value)
            ;
        }

        if ($start) {
            $builder = $builder
                -> andWhere('r.created_at > :start')
                -> setParameter('start', $start)
            ;
        }

        if ($end) {
            $builder = $builder
                -> andWhere('r.created_at < :end')
                -> setParameter('end', $end)
            ;
        }

        return $builder
            ->getQuery()
            ->getResult()
        ;
    }
}
