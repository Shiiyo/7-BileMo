<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
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
            $user = new User();

            $user->setName($name);
            $user->setEmail($faker->email());
            $user->setUsername($faker->userName());
            $user->setPassword($faker->password());

            $manager->persist($user);
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

