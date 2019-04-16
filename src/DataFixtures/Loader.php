<?php
/**
 * Created by PhpStorm.
 * User: MdJk
 * Date: 08/03/2019
 * Time: 13:49
 */

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Loader extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new UserFixtures();
        $user = $user->loader($manager, $this->passwordEncoder);
//        $employees = EmployeeFixtures::loader($manager, $user);
//        $this->setCompaniesEmployees($employees, $manager);
//        ProjectFixtures::loader($manager,$user);
    }

    private function setCompaniesEmployees(\ArrayObject $employees, ObjectManager $manager){
        foreach($employees as $employee){
            $companie = $employee->getCompanie();
            $companie->addEmployee($employee);
            $manager->persist($companie);
        }
        $manager->flush();
    }
}

