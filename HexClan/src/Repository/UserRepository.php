<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
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


    public function findOneByEmail($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findAllusers() :array
    {
        return $this->createQueryBuilder('u')
            ->where('u.compteType = :user')
            ->setParameter('user','user')
            ->getQuery()
            ->execute();

    }

    public function findUserActive($crit) :array
    {
        return $this->createQueryBuilder('u')
            ->where('u.status = :crit')
            ->setParameter('crit',$crit)
            ->getQuery()
            ->execute();
    }



    public function findUserBycin($cin){
        return $this->createQueryBuilder('u')
            ->where('u.cin LIKE :cin')
            ->setParameter('cin', '%'.$cin.'%')
            ->getQuery()
            ->getResult();
    }

    public function findUser($email,$pass) :array
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :mail')
            ->andWhere('u.password = :pass')
            ->setParameter('mail',$email)
            ->setParameter('pass',$pass)
            ->getQuery()
            ->execute();
    }





}
