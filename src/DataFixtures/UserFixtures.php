<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
//TODO composer require fixtures ?
class UserFixtures
{

    public function loader(ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->classicUser($manager, $passwordEncoder);
        $this->adminUser($manager, $passwordEncoder);
        $manager->flush();
        return $user;
    }

    public function classicUser(ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder){
        $user = new User();
        $user->setPassword($passwordEncoder->encodePassword(
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
        return $user;
    }

    public function adminUser(ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder){
        $user = new User();
        $user->setPassword($passwordEncoder->encodePassword(
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
