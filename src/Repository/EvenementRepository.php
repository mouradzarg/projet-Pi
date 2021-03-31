<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }


    /**
     * @return Query
     */

    public function findAllVisibleQuery(): Query
    {
        return $this->findVisibleQuery()
            ->getQuery();
    }

    /**
     * @return Evenement
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
     return $this->createQueryBuilder('e')
            ->where('e.prix <5000000');
    }

   /** public function findStudentByNsc($titre){
        return $this->createQueryBuilder('ev')
            ->where('ev.titre LIKE :titre1')
            ->setParameter('titre', '%'.$titre.'%')
            ->getQuery()
            ->getResult();
    }


    /** public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e
                FROM App\Entity\Evenement e
                WHERE e.title LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }



    // /**
    //  * @return EvenementFixture[] Returns an array of EvenementFixture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EvenementFixture
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
