<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use Doctrine\Common\Persistence\ObjectManager;

class EmployeeFixtures
{
    public static function loader(ObjectManager $manager)
    {
        for ($i = 1; $i < 51; $i++) {
            $employee = new Employee();
            //TODO Ask JP to know how many info needed for employees
            $employee->setFirstName('Prénom '.$i);
            $employee->setLastName('Nom '.$i);
            $employee->setPhoneNumber(1234567890);
            $employee->setEmail($i.'@'.$i.'.a');

            $manager->persist($employee);
        }
        $manager->flush();
    }
}
