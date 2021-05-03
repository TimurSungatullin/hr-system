<?php

namespace App\Repository;

use App\Entity\Rating;
use App\Entity\Resume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rating|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rating|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rating[]    findAll()
 * @method Rating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rating::class);
    }

    /**
     * @param int $resumeId
     * @param int|null $limit
     * @param int|null $offset
     * @return Rating[] Returns an array of Rating objects
     */
    public function findByResume(int $resumeId, $limit = null, $offset = null): array
    {
        $query = $this->createQueryBuilder('r')
            ->andWhere('r.resume = :val')
            ->setParameter('val', $resumeId)
            ->orderBy('r.date', 'DESC')
        ;

        if ($limit) {
            $query = $query -> setMaxResults($limit);
        }

        if ($offset) {
            $query = $query -> setFirstResult($offset);
        }

        return $query
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Rating
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
