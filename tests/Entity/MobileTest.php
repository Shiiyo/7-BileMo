<?php

namespace App\Tests\Entity;

use App\Entity\Mobile;
use PHPUnit\Framework\TestCase;

class MobileTest extends TestCase
{
    private $mobile;

    public function setUp()
    {
        $this->mobile = new Mobile();
    }

    public function testName()
    {
        $this->mobile->setName('Test');
        $this->assertSame('Test', $this->mobile->getName());
    }

    public function testPrice()
    {
        $this->mobile->setPrice(42);
        $this->assertEquals(42, $this->mobile->getPrice());
    }

    public function testDescription()
    {
        $this->mobile->setDescription('Test');
        $this->assertSame('Test', $this->mobile->getDescription());
    }

    public function testColor()
    {
        $this->mobile->setColor('Test');
        $this->assertSame('Test', $this->mobile->getColor());
    }

    public function testMemory()
    {
        $this->mobile->setMemory(42);
        $this->assertSame(42, $this->mobile->getMemory());
    }

    public function testScreen()
    {
        $this->mobile->setScreen(42);
        $this->assertSame(42, $this->mobile->getScreen());
    }
}