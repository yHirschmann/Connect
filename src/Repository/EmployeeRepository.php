<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * For search function
     * Request all employees that match with the query
     * Search critera:
     *      - Firstname
     *      - Lastname
     *      - Email
     *      - Companie name
     * @param string $query
     * @return mixed
     */
    public function findByQuery(string $query){
        $expr = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('c.id')
            ->from('App\\Entity\\Companies', 'c')
            ->where('c.companie_name LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->getDQL()
        ;

        return $this->createQueryBuilder('e')
            ->where('e.first_name LIKE :query')
            ->orWhere('e.last_name LIKE :query')
            ->orWhere('e.email LIKE :query')
            ->orWhere('e.companie IN ('. $expr.')')
            ->setParameter('query', '%'.$query.'%')
            ->getQuery()
            ->execute();
    }

    /**
     * Request all employees who have the same firstname and lastname
     *
     * @param String|null $lastName
     * @param String|null $firstName
     * @return mixed|null
     */
    public function findByExisting(String $lastName = null, String $firstName = null){
        if($lastName != null && $firstName != null){
            return $this->createQueryBuilder('e')
                ->andWhere('e.last_name = :lastName')
                ->andWhere('e.first_name = :firstName')
                ->setParameter('lastName',$lastName)
                ->setParameter('firstName',$firstName)
                ->getQuery()
                ->execute();
        }else{
            return null;
        }
    }

    /**
     * Find all employees that the emails are equals to the given email
     *
     * @param String|null $email
     * @return mixed
     */
    public function findByEmail(String $email = null){
        return $this->createQueryBuilder('e')
            ->andWhere('e.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->execute();
    }

    /**
     * Request all employees that have the same companie
     *
     * @param $id
     * @return mixed
     */
    public function findEmployeesInCompany($id)
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->andWhere('e.companie = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    /*
     /**
      * @return Employee[] Returns an array of Employee objects
      */
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
    public function findOneBySomeField($value): ?Employee
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