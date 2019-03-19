<?php

namespace App\Repository;

use App\Entity\CompanieEmployee;
use App\Entity\Companies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompanieEmployee|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanieEmployee|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanieEmployee[]    findAll()
 * @method CompanieEmployee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanieEmployeeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompanieEmployee::class);
    }

    // /**
    //  * @return CompanieEmployee[] Returns an array of CompanieEmployee objects
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
    public function findOneBySomeField($value): ?CompanieEmployee
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param $id Companies id
     * @return mixed
     */
    public function findEmployeesInCompany($id){
        return $this->createQueryBuilder('c')
            ->andWhere('c.companie = :id')
            ->andWhere('c.out_at = \'9999-01-01\'')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findCompanyInEmployee($id){
        //TODO Query an employee en watch if he is in a companie for the moment (where out_at = '9999-1-1)
        //Must return 1 Value
        return null;
    }
}
