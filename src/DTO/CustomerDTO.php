<?php

namespace App\DTO;

use App\Entity\Customer;

class CustomerDTO
{
    private $id;
    private $UserName;
    private $lastName;
    private $firstName;
    private $email;

    public function __construct(Customer $customer)
    {
        $this->setId($customer->getId());
        $this->setUserName($customer->getUser()->getName());
        $this->setLastName($customer->getLastName());
        $this->setFirstName($customer->getFirstName());
        $this->setEmail($customer->getEmail());
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
     * Get the value of UserName
     */ 
    public function getUserName()
    {
        return $this->UserName;
    }

    /**
     * Set the value of UserName
     *
     * @return  self
     */ 
    public function setUserName($UserName)
    {
        $this->UserName = $UserName;

        return $this;
    }

    /**
     * Get the value of lastName
     */ 
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of firstName
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}