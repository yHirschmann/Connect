<?php

namespace App\DataFixtures;

use App\Entity\CompanieType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CompanieTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $types = array('Architecte', 'Bureau d\'Etude', 'Carleur', 'BTP', 'Eclairagiste', 'Electricien',);

        foreach ($types as $type){
            $companieType = new CompanieType();
            $companieType->setLabel($type);
            $manager->persist($companieType);
        }
        $manager->flush();
    }
}
