<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        $encoder = new UserPasswordEncoderInterface;
        $faker = \Faker\Factory::create('fr_FR');

        foreach ($this->getNames() as $name) {
            $user = new User();

            $user->setName($name);
            $user->setEmail($faker->email());
            $user->setRoles(["ROLE_ADMIN"]);
            $user->setUsername($faker->userName());

            $password = $encoder->encodePassword($user, "admin");
            $user->setPassword($password);

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
