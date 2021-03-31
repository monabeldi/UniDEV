<?php

namespace App\Repository;

use App\Entity\Transports;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transports|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transports|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transports[]    findAll()
 * @method Transports[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransportsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transports::class);
    }


}
