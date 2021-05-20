<?php

namespace App\Repository;

use App\Entity\Uber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Uber|null find($id, $lockMode = null, $lockVersion = null)
 * @method Uber|null findOneBy(array $criteria, array $orderBy = null)
 * @method Uber[]    findAll()
 * @method Uber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Uber::class);
    }

    public function findUberByNom($nom_uber){
        return $this->createQueryBuilder('uber')
            ->where('uber.nom_uber LIKE :nom_uber')
            ->setParameter('nom_uber', '%'.$nom_uber.'%')
            ->getQuery()
            ->getArrayResult();
    }
    public function findAllNOTRESERVED():
    array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT uber.* FROM `uber` WHERE uber.id NOT IN (SELECT DISTINCT transports.uber_id FROM `transports` WHERE transports.uber_id > 0)';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function findMyreserved(int $user_id):
    array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT uber.* FROM  `uber` , `transports` WHERE uber.id = transports.uber_id AND transports.user_id = :user_id';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }





    // /**
    //  * @return Uber[] Returns an array of Uber objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Uber
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
