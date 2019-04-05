<?php

namespace App\DataFixtures;

use App\Entity\CompanieEmployee;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CompanieEmployeeFixtures
{
    public static function loader(ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $companies = CompanieFixtures::loader($manager);
        $employees = EmployeeFixtures::loader($manager);
        $user = new UserFixtures();
        $user = $user->loader($manager, $passwordEncoder);
        for ($i = 1; $i < 101; $i++) {
            $ce = new CompanieEmployee();
            $ce->setCompanie($companies->offsetGet(mt_rand(0,19)));
            $ce->setEmployee($employees->offsetGet(mt_rand(0,49)));
            $ce->setAddedBy($user);
            $manager->persist($ce);
        }
        $manager->flush();
        return $user;
    }
}
