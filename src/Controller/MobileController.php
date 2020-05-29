<?php

namespace App\Controller;

use App\Entity\Mobile;
use App\Repository\MobileRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MobileController extends AbstractController
{
    /**
     * @Route("/mobiles/{id}", name="mobile_show", methods={"GET"})
     */
    public function showAction(SerializerInterface $serializer, MobileRepository $repo, $id)
    {
        $mobile = $repo->findOneById($id);

        $data = $serializer->serialize($mobile, 'json');
        
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}