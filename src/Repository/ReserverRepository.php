<?php

namespace App\Repository;

use App\Entity\Reserver;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reserver|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reserver|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reserver[]    findAll()
 * @method Reserver[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReserverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reserver::class);
    }

    /**
     * @return Reserver
     */
    public function findAllVisible_ev(): array
    {
        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reserver
     */

    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }


    private function findVisibleQuery() : QueryBuilder
    {
        return $this->createQueryBuilder('r');

    }
    // /**
    //  * @return Reserver[] Returns an array of Reserver objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reserver
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
