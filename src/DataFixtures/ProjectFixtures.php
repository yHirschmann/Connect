<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class ProjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 101; $i++) {
            $project = new Project();

            $project->setProjectName('project '.$i);
            $project->setCost(mt_rand(10000, 1000000));
            $project->setAdress($i.' rue du marché');
            $project->setPostalCode(mt_rand(6700,6900));
            $project->setCity('Strasgourg');
            $project->setStartedAt(\DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s')));
            $project->setEndedAt(\DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s'))->add(new \DateInterval('P'.mt_rand(0,30).'D')));
            $project->setImgPath('build/uploads/img_project/img1.jpg');
            $project->setUpdatedAt(\DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s')));
            $project->setStatut(mt_rand(1,3));
            $manager->persist($project);
        }
        $manager->flush();
    }
}