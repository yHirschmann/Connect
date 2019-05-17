<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Vich\UploaderBundle\Entity\File;

class EmployeeFixtures
{
    public static function loader(ObjectManager $manager, User $user)
    {
        $companie = CompanieFixtures::loader($manager);
        $employee = new Employee();
        $employee->setFirstName("Yann");
        $employee->setLastName("HIRSCHMANN");
        $employee->setPhoneNumber("0600000000");
        $employee->setEmail("yann.hirschmann@hotmail.com");
        $employee->setPosition("informatitien");
        $employee->setCompanie($companie);
        $employee->setAddedBy($user);
        $manager->persist($employee);
        $companie->addEmployee($employee);
        $manager->flush();
    }
}
