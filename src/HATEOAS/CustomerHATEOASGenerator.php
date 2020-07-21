<?php

namespace App\HATEOAS;

use App\Entity\Customer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CustomerHATEOASGenerator
{
    private $router;
    private $customer;

    public function __construct(UrlGeneratorInterface $router, Customer $customer)
    {
        $this->router = $router;
        $this->customer = $customer;
    }

    public function selfLink()
    {
        $link = $this->router->generate('customer_show', ['id' => $this->customer->getId()], 3);
        $this->customer->links[] = ['self' => $link];
        return true;
    }

    public function listLink()
    {
        $link = $this->router->generate('customer_list', [], 3);
        $this->customer->links[] = ['list' => $link];
        return true;
    }

    public function modifyLink()
    {
        $link = $this->router->generate('customer_update', ['id' => $this->customer->getId()], 3);
        $this->customer->links[] = ['modify' => $link];
        return true;
    }

    public function deleteLink()
    {
        $link = $this->router->generate('customer_delete', ['id' => $this->customer->getId()], 3);
        $this->customer->links[] = ['delete' => $link];
        return true;
    }
}
