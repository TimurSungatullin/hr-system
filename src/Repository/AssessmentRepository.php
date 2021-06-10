<?php

namespace App\Repository;

use App\Entity\Assessment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Assessment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assessment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assessment[]    findAll()
 * @method Assessment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssessmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assessment::class);
    }
}
