<?php

namespace App\Repository;

use App\Entity\StatusHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatusHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusHistory[]    findAll()
 * @method StatusHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatusHistory::class);
    }
}
