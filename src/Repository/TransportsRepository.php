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
 public function findSelectedUber(int $user_id , int $uber_id)

    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT transports.* FROM  `transports` WHERE transports.user_id = :user_id AND transports.uber_id= :uber_id';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id'=> $user_id , 'uber_id'=> $uber_id]);
        return $stmt->fetch();
    }
    public function findSelectedCar(int $user_id , int $car_id)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT transports.id FROM  `transports` WHERE transports.user_id = :user_id AND transports.car_id= :car_id';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id'=> $user_id , 'car_id'=> $car_id]);
        return $stmt->fetch();
    }



}
