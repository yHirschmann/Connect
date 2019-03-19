<?php

namespace App\DataFixtures;

use App\Entity\CompanieEmployee;
use Doctrine\Common\Persistence\ObjectManager;

class CompanieEmployeeFixtures
{
    public static function loader(ObjectManager $manager)
    {
        $companies = CompanieFixtures::loader($manager);
        $employees = EmployeeFixtures::loader($manager);
        for ($i = 1; $i < 101; $i++) {
            $ce = new CompanieEmployee();
            $ce->setCompanie($companies->offsetGet(mt_rand(0,19)));
            $ce->setEmployee($employees->offsetGet(mt_rand(0,49)));
            $ce->setEnterAt(\DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s')));
            $manager->persist($ce);
        }
        $manager->flush();
    }
}
