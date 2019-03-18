<?php

namespace App\DataFixtures;

use App\Entity\Companies;
use Doctrine\Common\Persistence\ObjectManager;

class CompanieFixtures {

    public static function loader(ObjectManager $manager)
    {
        $types = CompanieTypeFixtures::loader($manager);
        for ($i = 1; $i < 21; $i++) {
            $companie = new Companies();
            $companie->setCompanieName('Entreprise '.$i);
            $companie->setNbProjects(mt_rand(0,21));
            $companie->setCity('Strasbourg');
            $companie->setAdress($i.' rue des Marchands');
            $companie->setPostalCode(strval(mt_rand(6699,6901)));
            $companie->setPhoneNumber('1234567890');
            $companie->setEffective(mt_rand(5,50));
            $companie->setSocialReason($companie->getCompanieName().' SA');
            $companie->setTurnover(mt_rand(100000, 1000000));
            $companie->setType($types->offsetGet(mt_rand(0,5)));
            $manager->persist($companie);
        }
        $manager->flush();
    }
}
