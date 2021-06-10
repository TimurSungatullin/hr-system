<?php

namespace App\Repository;

use App\Entity\UserTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserTest[]    findAll()
 * @method UserTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserTest::class);
    }
}
