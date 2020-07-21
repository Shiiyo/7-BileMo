<?php

namespace App\HATEOAS;

use App\Entity\Mobile;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MobileHATEOASGenerator
{
    private $router;
    private $mobile;

    public function __construct(UrlGeneratorInterface $router, Mobile $mobile)
    {
        $this->router = $router;
        $this->mobile = $mobile;
    }

    public function listLink()
    {
        $link = $this->router->generate('mobile_list', [], 3);
        $this->mobile->links[] = ['list' => $link];
        return true;
    }
}
