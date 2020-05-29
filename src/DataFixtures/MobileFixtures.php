<?php

namespace App\DataFixtures;

use App\Entity\Mobile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MobileFixtures extends Fixture
{
    private $names = [
        'Basic BilMo',
        'BilMo Max',
        'BilMo 9',
        'BilMo Special Edition',
        'BilMo 10 Plus',
        'BilMo Note 11',
        'BilMo Plus',
        'BileMo 12',
        'BileMo 11',
        'BileMo Ultimate',

    ];

    private $memory = [
        '32',
        '64',
        '128',
        '256',
    ];

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        
        foreach ($this->getNames() as $name)
        {
            $mobile = new Mobile();

            $mobile->setName($name);
            $mobile->setPrice($faker->randomFloat(2, 500, 3000));
            $mobile->setDescription($faker->paragraph(8));
            $mobile->setColor($faker->safeColorName);
            $mobile->setMemory($faker->randomElement($this->getMemory()));
            $mobile->setScreen($faker->numberBetween(4,9));

            $manager->persist($mobile);
        }
    }

    /**
     * Get the value of names
     */ 
    public function getNames()
    {
        return $this->names;
    }

    /**
     * Get the value of memory
     */ 
    public function getMemory()
    {
        return $this->memory;
    }
}

