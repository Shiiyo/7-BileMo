<?php

namespace App\Controller;

use App\Repository\MobileRepository;
use App\Normalizer\Normalizer as Normalizer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    public function listAction(SerializerInterface $serializer, MobileRepository $repo, Request $request)
    {
        //Paging
        $offset = max(0, $request->get('offset'));
        $nbResult =  max(2, $request->get('nbResult'));
        $totalPage = $repo->findMaxNbOfPage($nbResult);

        if($offset > $totalPage || $offset <= 0) {
            throw new NotFoundHttpException("La page n'existe pas");
        }

        $page = $repo->getMobilePage($offset, $nbResult);

        $normalizer = new Normalizer;
        $data = $normalizer->normalize($page, 'list');
        $jsonData = $serializer->serialize($data, 'json');

        return new Response($jsonData, 200, ['Content-Type', 'application/json']);
    }
}