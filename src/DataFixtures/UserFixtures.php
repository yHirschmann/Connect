<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures
{
    public function loader(ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->classicUser($manager, $passwordEncoder);
        $this->JPSUser($manager, $passwordEncoder);
        $this->adminUser($manager, $passwordEncoder);
        $this->guestUser($manager, $passwordEncoder);
        $manager->flush();
        return $user;
    }

    private function classicUser(ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder){
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
            ['ROLE_USER','ROLE_REGULAR']
        );
        $manager->persist($user);
        return $user;
    }

    private function JPSUser(ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder){
        $user = new User();
        $user->setPassword($passwordEncoder->encodePassword(
            $user,
            'JPSE1267.'
        ));
        $user->setFirstName(
            'JPS'
        );
        $user->setLastName(
            'JPS'
        );
        $user->setPhoneNumber(
            '1234567890'
        );
        $user->setEmail(
            'jpseclairage@gmail.com'
        );
        $user->setRoles(
            ['ROLE_USER','ROLE_REGULAR']
        );
        $manager->persist($user);
    }

    private function guestUser(ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder){
        $user = new User();
        $user->setPassword($passwordEncoder->encodePassword(
            $user,
            'Aa1234567890.'
        ));
        $user->setFirstName(
            'UserGuest'
        );
        $user->setLastName(
            'UserGuest'
        );
        $user->setPhoneNumber(
            '1234567890'
        );
        $user->setEmail(
            'guest@a.a'
        );
        $user->setRoles(
            ['ROLE_USER']
        );

        $manager->persist($user);
    }

    private function adminUser(ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder){
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
            ['ROLE_ADMIN','ROLE_USER','ROLE_REGULAR']
        );

        $manager->persist($user);
    }
}
