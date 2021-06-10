<?php

namespace App\Repository;

use App\Entity\QuestionBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuestionBlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionBlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionBlock[]    findAll()
 * @method QuestionBlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionBlockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionBlock::class);
    }
}
