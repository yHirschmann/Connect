<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;


class ProjectFixtures
{
    public static function loader(ObjectManager $manager, User $user)
    {
        for ($i = 1; $i < 101; $i++) {
            $project = new Project();
            $project->setProjectName('project '.$i)
                    ->setCost(mt_rand(10000, 1000000))
                    ->setAdress($i.' rue du marché')
                    ->setPostalCode(mt_rand(6700,6900))
                    ->setCity('Strasgourg')
                    ->setImgPath('build/project/image/img1.jpg')
                    ->setStatut(mt_rand(1,3))
                    ->setStartedAt(\DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s')))
                    ->setCreatedAt(\DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s')))
                    ->setCreatedBy($user);
            $project->setEndedAt(\DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s'))->add(new \DateInterval('P'.mt_rand(0,30).'D')));
//            $project->setUpdatedAt(\DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s')));
            $manager->persist($project);
        }
        $manager->flush();
    }
}