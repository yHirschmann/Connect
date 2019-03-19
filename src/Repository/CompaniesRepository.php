<?php

namespace App\Repository;

use App\Entity\Companies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Companies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Companies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Companies[]    findAll()
 * @method Companies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompaniesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Companies::class);
    }

    // /**
    //  * @return Companies[] Returns an array of Companies objects
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
    public function findOneBySomeField($value): ?Companies
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByExisting(string $name, string $city, string $adress){
        return $this->createQueryBuilder('c')
                    ->andWhere('c.companie_name = :name')
                    ->andWhere('c.City = :city')
                    ->andWhere('c.Adress = :adress')
                    ->setParameter('name', $name)
                    ->setParameter('city', $city)
                    ->setParameter('adress', $adress)
                    ->getQuery()
                    ->execute();
    }
}
