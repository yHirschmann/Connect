<?php

namespace App\DataFixtures;

use App\Entity\Companies;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CompanieFixtures extends Fixture
{
    public function __construct()
    {

    }

    public function load(ObjectManager $manager)
    {
        
        for ($i = 1; $i < 21; $i++) {
            $companie = new Companies();
            //TODO Ask JP to know how many info needed for companies
            $companie->setCompanieName('Entreprise '.$i);
            $companie->setNbProjects(mt_rand(0,21));
            $companie->setCity('Strasbourg');
            $companie->setAdress($i.' rue des Marchands');
            $companie->setPostalCode(strval(mt_rand(6699,6901)));
            $companie->setPhoneNumber('1234567890');
            $companie->setEffective(mt_rand(5,50));
            $companie->setSocialReason($companie->getCompanieName().' SA');
            $companie->setTurnover(mt_rand(100000, 1000000));
            $companie->setTypeId(mt_rand(1,6));
            $manager->persist($companie);
        }
        $manager->flush();
    }
}
