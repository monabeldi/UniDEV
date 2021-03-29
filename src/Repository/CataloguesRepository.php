<?php

namespace App\Repository;

use App\Entity\Catalogues;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Catalogues|null find($id, $lockMode = null, $lockVersion = null)
 * @method Catalogues|null findOneBy(array $criteria, array $orderBy = null)
 * @method Catalogues[]    findAll()
 * @method Catalogues[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CataloguesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Catalogues::class);
    }
    public function findCatalogueByNom($nom_plat){
        return $this->createQueryBuilder('catalogue')
            ->where('catalogue.nom_plat LIKE :nom_plat')
            ->setParameter('nom_plat', '%'.$nom_plat.'%')
            ->getQuery()
            ->getArrayResult();
    }

    // /**
    //  * @return Catalogues[] Returns an array of Catalogues objects
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
    public function findOneBySomeField($value): ?Catalogues
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
