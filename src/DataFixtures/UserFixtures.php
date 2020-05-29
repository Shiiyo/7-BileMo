<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $clientArray = $manager->getRepository('App\Entity\Client')->findAll();
        foreach($clientArray as $client){
            for ($i = 1; $i <= 6; $i++) {
                $user = new User();

                $user->setClient($client);
                $client->addUser($user);
                $user->setLastName($faker->lastName());
                $user->setFirstName($faker->firstName());
                $user->setEmail($faker->email());

                $manager->persist($user);
                $manager->persist($client);
            }
        }
    }
}

