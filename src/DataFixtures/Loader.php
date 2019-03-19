<?php
/**
 * Created by PhpStorm.
 * User: MdJk
 * Date: 08/03/2019
 * Time: 13:49
 */

namespace App\DataFixtures;


use App\Entity\CompanieEmployee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Loader extends Fixture
{

    public function load(ObjectManager $manager)
    {
        CompanieEmployeeFixtures::loader($manager);
        ProjectFixtures::loader($manager);
    }
}