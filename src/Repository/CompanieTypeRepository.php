<?php

namespace App\Repository;

use App\Entity\CompanieType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompanieType|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanieType|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanieType[]    findAll()
 * @method CompanieType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanieTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompanieType::class);
    }

    // /**
    //  * @return CompanieType[] Returns an array of CompanieType objects
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
    public function findOneBySomeField($value): ?CompanieType
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
