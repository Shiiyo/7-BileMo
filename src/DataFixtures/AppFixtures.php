<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Create Mobiles
        $mobileFixture = new MobileFixtures();
        $mobileFixture->load($manager);

        //Create Clients
        $clientFixture = new ClientFixtures();
        $clientFixture->load($manager);

        $manager->flush();

        //Create Users
        $userFixture = new UserFixtures();
        $userFixture->load($manager);

        $manager->flush();
    }
}
