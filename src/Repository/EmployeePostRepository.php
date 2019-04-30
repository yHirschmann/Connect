<?php

namespace App\Repository;

use App\Entity\EmployeePost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EmployeePost|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeePost|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeePost[]    findAll()
 * @method EmployeePost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeePostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EmployeePost::class);
    }

    // /**
    //  * @return EmployeePost[] Returns an array of EmployeePost objects
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
    public function findOneBySomeField($value): ?EmployeePost
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
