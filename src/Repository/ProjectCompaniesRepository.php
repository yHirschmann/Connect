<?php

namespace App\Repository;

use App\Entity\Companies;
use App\Entity\ProjectCompanies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProjectCompanies|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectCompanies|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectCompanies[]    findAll()
 * @method ProjectCompanies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectCompaniesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProjectCompanies::class);
    }

    public static function existingProjectCompanieCriteria(Companies $companies): Criteria
    {
        return Criteria::create()->andWhere(Criteria::expr()->eq('companies', $companies));
    }

    // /**
    //  * @return ProjectCompanies[] Returns an array of ProjectCompanies objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProjectCompanies
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
