<?php

namespace App\Controller;

use App\Repository\MobileRepository;
use App\Normalizer\Normalizer as Normalizer;
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

        return new Response($data, 200, ['Content-Type', 'application/json']);
    }

    /**
     * @Route("/mobiles", name="mobile_list", methods={"GET"})
     */
    public function listAction(SerializerInterface $serializer, MobileRepository $repo)
    {
        $mobiles = $repo->findAll();

        $normalizer = new Normalizer;

        $data = $normalizer->normalize($mobiles, 'list');
        $jsonData = $serializer->serialize($data, 'json');

        return new Response($jsonData, 200, ['Content-Type', 'application/json']);
    }
}