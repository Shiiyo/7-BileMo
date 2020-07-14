<?php

namespace App\Tests\Entity;

use App\Entity\Customer;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    private $customer;

    public function setUp()
    {
        $this->customer = new Customer();
    }

    public function testLastName()
    {
        $this->customer->setLastName('Test');
        $this->assertSame('Test', $this->customer->getLastName());
    }

    public function testFirstName()
    {
        $this->customer->setFirstName('Test');
        $this->assertSame('Test', $this->customer->getFirstName());
    }

    public function testEmail()
    {
        $this->customer->setEmail('test@test.com');
        $this->assertSame('test@test.com', $this->customer->getEmail());
    }

    public function testUser()
    {
        $user = new User;
        $this->customer->setUser($user);
        $this->assertSame($user, $this->customer->getUser());
    }
}