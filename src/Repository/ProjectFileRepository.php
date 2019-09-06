<?php

namespace App\Repository;

use App\Entity\ProjectFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method ProjectFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectFile[]    findAll()
 * @method ProjectFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectFileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProjectFile::class);
    }

    /**
     * Get all images of projects
     *
     * @return mixed
     */
    public function getProjectImage(){
        return $this->createQueryBuilder('pf')
                    ->andWhere('pf.isProjectImage = :bool')
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Get the project Image by the id of the project
     *
     * @param $projectId
     * @return mixed
     */
    public function getProjectImageById($projectId){
        return $this->createQueryBuilder('pf')
            ->andWhere('pf.project = :id')
            ->andWhere('pf.isProjectImage = :bool')
            ->setParameter('id', $projectId)
            ->setParameter('bool', true)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    /**
     * check if the given file is already existing by formatting the file name
     *
     * @param UploadedFile $file
     * @return Criteria
     */
    static public function existingProjectFileCritera(UploadedFile $file): Criteria
    {
        return Criteria::create()
            ->andWhere(
                Criteria::expr()
                    ->eq('fileOriginalName', str_replace(' ', '_', $file->getClientOriginalName()))
            );
    }
    // /**
    //  * @return ProjectFile[] Returns an array of ProjectFile objects
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
    public function findOneBySomeField($value): ?ProjectFile
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
