<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Customer;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    public function setUp()
    {
        $this->user = new User();
    }

    public function testUsername()
    {
        $this->user->setUsername('test');
        $this->assertSame('test', $this->user->getUsername());
    }

    public function testRoles()
    {
        $role[] = 'ROLE_USER';
        $this->assertSame($role , $this->user->getRoles());
    }

    public function testPassword()
    {
        $this->user->setPassword('password');
        $this->assertSame('password', $this->user->getPassword());
    }

    public function testName()
    {
        $this->user->setName('Name');
        $this->assertSame('Name', $this->user->getName());
    }

    public function testCustomers()
    {
        $customer = new Customer;
        $this->user->addCustomer($customer);
        $customerArray[] = $customer;
        $customerCollection = new ArrayCollection($customerArray);
        $this->assertEquals($customerCollection, $this->user->getCustomers());
    }
}