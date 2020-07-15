<?php

namespace App\DTO;

use App\Entity\Mobile;

class MobileDTO
{
    private $id;
    private $name;
    private $price;
    private $description;
    private $color;
    private $memory;
    private $screen;
    private $links;

    public function __construct(Mobile $mobile)
    {
        $this->setId($mobile->getId());
        $this->setName($mobile->getName());
        $this->setPrice($mobile->getPrice());
        $this->setDescription($mobile->getDescription());
        $this->setColor($mobile->getColor());
        $this->setMemory($mobile->getMemory());
        $this->setScreen($mobile->getScreen());
        $this->setLinks($mobile->links);
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of color
     *
     * @return  self
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get the value of memory
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Set the value of memory
     *
     * @return  self
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * Get the value of screen
     */
    public function getScreen()
    {
        return $this->screen;
    }

    /**
     * Set the value of screen
     *
     * @return  self
     */
    public function setScreen($screen)
    {
        $this->screen = $screen;

        return $this;
    }

    /**
     * Get the value of links
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set the value of links
     *
     * @return  self
     */
    public function setLinks($links)
    {
        $this->links = $links;

        return $this;
    }
}
