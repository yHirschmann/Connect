<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
//TODO composer require fixtures ?
class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->classicUser($manager);
        $this->adminUser($manager);
        $manager->flush();
    }

    public function classicUser(ObjectManager $manager){
        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'Aa1234567890.'
        ));
        $user->setFirstName(
            'UserA'
        );
        $user->setLastName(
            'UserA'
        );
        $user->setPhoneNumber(
            '1234567890'
        );
        $user->setEmail(
            'a@a.a'
        );
        $user->setRoles(
            ['ROLE_USER']
        );
        $manager->persist($user);
    }

    public function adminUser(ObjectManager $manager){
        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'Aa1234567890.'
        ));
        $user->setFirstName(
            'UserAdmin'
        );
        $user->setLastName(
            'UserAdmin'
        );
        $user->setPhoneNumber(
            '1234567890'
        );
        $user->setEmail(
            'admin@a.a'
        );
        $user->setRoles(
            ['ROLE_ADMIN']
        );

        $manager->persist($user);
    }
}
