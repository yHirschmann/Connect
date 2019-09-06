<?php

namespace App\Repository;

use App\Entity\Companies;
use App\Entity\Project;
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

    /**
     * Get only companies that match with the function parameter
     *
     * @param Companies $companies
     * @return Criteria
     */
    public static function existingProjectCompanieCriteria(Companies $companies): Criteria
    {
        return Criteria::create()
            ->andWhere(
                Criteria::expr()
                    ->eq('companies', $companies)
            );
    }

    /**
     * Get the projectCompanies with a specific project and a specific company
     *
     * @param Project $project
     * @param Companies $companies
     * @return mixed
     */
    public function getByProjectAndCompanie(Project $project, Companies $companies){
        return $this->createQueryBuilder('pc')
            ->where('pc.project = :project')
            ->andWhere('pc.companies = :companie')
            ->setParameter('project', $project)
            ->setParameter('companie', $companies)
            ->getQuery()
            ->execute()
        ;
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
