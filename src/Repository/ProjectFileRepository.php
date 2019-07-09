<?php

namespace App\Repository;

use App\Entity\ProjectFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

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

    public function getProjectImage(){
        return $this->createQueryBuilder('pf')
                    ->andWhere('pf.isProjectImage = :bool')
                    ->getQuery()
                    ->getResult();
    }

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
