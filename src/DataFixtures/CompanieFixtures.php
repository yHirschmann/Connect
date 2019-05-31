<?php

namespace App\DataFixtures;

use App\Entity\Companies;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;

class CompanieFixtures {

    public static function loader(ObjectManager $manager, User $user)
    {
        $type = CompanieTypeFixtures::loader($manager);

        $companie = new Companies();
        $companie->setCompanieName("JPS Eclairage");
        $companie->setAdress("13A Rue Hannah Arendt, Parc des Forges");
        $companie->setPostalCode("67200");
        $companie->setCity("Strasbourg");
        $companie->setPhoneNumber("");
        $companie->setTurnover(3750000);
        $companie->setSocialReason("JPS Eclairage");
        $companie->setType($type);
        $companie->setAddedAt(new DateTime('NOW'));
        $companie->setAddedBy($user);
        $manager->persist($companie);
        $manager->flush();
        return $companie;
    }
}
