<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ClientFixtures extends Fixture
{
    private $names = [
        'SFR',
        'Free',
        'Bouygues',
        'Orange',
    ];

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        foreach ($this->getNames() as $name)
        {
            $client = new Client();

            $client->setName($name);
            $client->setEmail($faker->email());
            $client->setLogin($faker->userName());
            $client->setPassword($faker->password());

            $manager->persist($client);
        }
    }

    /**
     * Get the value of names
     */ 
    public function getNames()
    {
        return $this->names;
    }
}

