<?php

namespace App\DataFixtures;

use App\Entity\CompanieType;
use Doctrine\Common\Persistence\ObjectManager;

class CompanieTypeFixtures
{
    public static function loader(ObjectManager $manager)
    {
        $companieType = new CompanieType();
        $companieType->setLabel("Specialiste en éclairage");
        $manager->persist($companieType);
        $manager->flush();
        return $companieType;
    }
}
