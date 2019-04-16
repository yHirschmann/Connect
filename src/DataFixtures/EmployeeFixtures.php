<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EmployeeFixtures
{
    public static function loader(ObjectManager $manager, User $user)
    {
        $companieArray = CompanieFixtures::loader($manager);
        $EmpArray = new \ArrayObject();
        for ($i = 1; $i < 101; $i++) {
            $employee = new Employee();
            $employee->setFirstName('Prénom '.$i);
            $employee->setLastName('Nom '.$i);
            $employee->setPhoneNumber(1234567890);
            $employee->setEmail($i.'@'.$i.'.a');
            $companie = $companieArray->offsetGet(mt_rand(0,count($companieArray)-1));
            $employee->setCompanie($companie);
            $employee->setAddedBy($user);
            $EmpArray->append($employee);
            $manager->persist($employee);
        }
        $manager->flush();
        return $EmpArray;
    }
}
