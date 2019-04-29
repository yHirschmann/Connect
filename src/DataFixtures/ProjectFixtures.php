<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProjectFixtures
{
    public static function loader(ObjectManager $manager, User $user)
    {
        $employee = EmployeeFixtures::loader($manager, $user);

        $file = new UploadedFile("assets/images/project/green_er-21-retouche.jpg","green_er-21-retouche.jpg");

        $project = new Project();
        $project->setProjectName('Projet Test')
                ->setCost(mt_rand(10000, 1000000))
                ->setAdress('15 Rue du Maréchal Lefebvre')
                ->setPostalCode(67100)
                ->setCity('Strasgourg')
                ->setPhase(mt_rand(0,4))
                ->setStartedAt(\DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s')))
                ->setCreatedAt(\DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s')))
                ->setCreatedBy($user)
                ->addContact($employee)
                ->setEndedAt(\DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s'))->add(new \DateInterval('P'.mt_rand(0,30).'D')));
        $project->setImageFile($file);
        $project->setImage($file);
        $manager->persist($project);
        $manager->flush();
    }
}