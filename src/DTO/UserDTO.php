<?php

namespace App\DTO;

use App\Entity\User;

class UserDTO
{
    private $id;
    private $clientName;
    private $lastName;
    private $firstName;
    private $email;

    public function __construct(User $user)
    {
        $this->setId($user->getId());
        $this->setClientName($user->getClient()->getName());
        $this->setLastName($user->getLastName());
        $this->setFirstName($user->getFirstName());
        $this->setEmail($user->getEmail());
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
     * Get the value of clientName
     */ 
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * Set the value of clientName
     *
     * @return  self
     */ 
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;

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