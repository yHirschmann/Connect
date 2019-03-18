<?php

namespace App\DataFixtures;

use App\Entity\CompanieType;
use Doctrine\Common\Persistence\ObjectManager;

class CompanieTypeFixtures
{
    public static function loader(ObjectManager $manager)
    {
        $types = array('Architecte', 'Bureau d\'Etude', 'Carleur', 'BTP', 'Eclairagiste', 'Electricien',);
        $CompTypeArray = new \ArrayObject();
        foreach ($types as $type){
            $companieType = new CompanieType();
            $companieType->setLabel($type);
            $CompTypeArray->append($companieType);
            $manager->persist($companieType);
        }
        $manager->flush();
        return $CompTypeArray;
    }
}
