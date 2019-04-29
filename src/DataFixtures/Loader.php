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
        EmployeeFixtures::loader($manager, $user);
    }
}

