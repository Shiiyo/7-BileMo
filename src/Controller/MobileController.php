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
     * @Route("/mobiles/{id}", name="mobile_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function showAction(SerializerInterface $serializer, MobileRepository $repo, $id)
    {
        $mobile = $repo->findOneById($id);

        $data = $serializer->serialize($mobile, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
 
        return $response;
    }

    /**
     * @Route("/mobiles", name="mobile_list", methods={"GET"})
     */
    public function listAction(SerializerInterface $serializer, MobileRepository $repo)
    {
        $mobiles = $repo->findAll();

        $data = $serializer->serialize($mobiles, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}