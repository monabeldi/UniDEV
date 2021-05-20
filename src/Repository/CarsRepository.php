<?php

namespace App\Repository;

use App\Entity\Cars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cars|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cars|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cars[]    findAll()
 * @method Cars[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cars::class);
    }
    public function findCarByNom($marque_car){
        return $this->createQueryBuilder('car')
            ->where('car.marque_car LIKE :marque_car')
            ->setParameter('marque_car', '%'.$marque_car.'%')
            ->getQuery()
            ->getArrayResult();
    }
    public function findAllNOTRESERVED():
    array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT cars.* FROM `cars` WHERE cars.id NOT IN (SELECT DISTINCT transports.car_id FROM `transports` WHERE transports.car_id > 0 )';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function findMyreserved(int $user_id):
    array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT cars.* FROM  `cars` , `transports` WHERE cars.id = transports.car_id AND transports.user_id = :user_id';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    // /**
    //  * @return Cars[] Returns an array of Cars objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cars
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
