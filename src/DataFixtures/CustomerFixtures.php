<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $userArray = $manager->getRepository('App\Entity\User')->findAll();
        foreach ($userArray as $user) {
            for ($i = 1; $i <= 6; $i++) {
                $customer = new Customer();

                $customer->setUser($user);
                $user->addCustomer($customer);
                $customer->setLastName($faker->lastName());
                $customer->setFirstName($faker->firstName());
                $customer->setEmail($faker->email());

                $manager->persist($customer);
                $manager->persist($user);
            }
        }
    }
}
