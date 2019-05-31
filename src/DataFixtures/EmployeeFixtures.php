<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class EmployeeFixtures
{
    public static function loader(ObjectManager $manager, User $user)
    {
        $companie = CompanieFixtures::loader($manager, $user);
        $employee = new Employee();
        $employee->setFirstName("Yann");
        $employee->setLastName("HIRSCHMANN");
        $employee->setPhoneNumber("0600000000");
        $employee->setEmail("yann.hirschmann@hotmail.com");
        $employee->setPosition("informaticien");
        $employee->setCompanie($companie);
        $employee->setAddedBy($user);
        $manager->persist($employee);
        $companie->addEmployee($employee);
        $manager->flush();
    }
}
