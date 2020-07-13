<?php

namespace App\Controller;

use App\DTO\MobileDTO;
use App\Repository\MobileRepository;
use App\HATEOAS\MobileHATEOASGenerator;
use App\Normalizer as Normalizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class MobileController extends AbstractController
{
    /**
     * @Route("/mobiles/{id}", name="mobile_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function showAction(SerializerInterface $serializer, MobileRepository $repo, $id, UrlGeneratorInterface $router)
    {
        $mobile = $repo->findOneById($id);

        //Add links
        $HATEOASGenerator = new MobileHATEOASGenerator($router, $mobile);
        $HATEOASGenerator->listLink();
        $mobileDTO = new MobileDTO($mobile);

        $data = $serializer->serialize($mobileDTO, 'json');

        $response = new JsonResponse($data, 200, [], true);
        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);
        $response->setPublic();
        $response->setMaxAge(3500);

        return $response;
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

        $response = new JsonResponse($jsonData, 200, [], true);
        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);
        $response->setPublic();
        $response->setMaxAge(3500);

        return $response;
    }
}