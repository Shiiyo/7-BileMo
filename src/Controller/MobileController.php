<?php

namespace App\Controller;

use Exception;
use App\DTO\MobileDTO;
use App\Normalizer as Normalizer;
use App\Repository\MobileRepository;
use App\HATEOAS\MobileHATEOASGenerator;
use App\Responder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MobileController extends AbstractController
{
    /**
     * @Route("/mobiles/{id}", name="mobile_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function showAction(SerializerInterface $serializer, MobileRepository $repo, UrlGeneratorInterface$router, Request $request)
    {
        $id = $request->get('id');
        $mobile = $repo->findOneById($id);

        if ($mobile === null) {
            throw new Exception("Ce mobile n'existe pas.", 404);
        }

        //Add links
        $HATEOASGenerator = new MobileHATEOASGenerator($router, $mobile);
        $HATEOASGenerator->listLink();
        $mobileDTO = new MobileDTO($mobile);

        $data = $serializer->serialize($mobileDTO, 'json');

        $responder = new Responder;
        $response = $responder->createReponse($request, $data, 200);

        return $response;
    }

    /**
     * @Route("/mobiles", name="mobile_list", methods={"GET"})
     */
    public function listAction(SerializerInterface $serializer, MobileRepository $repo, Request $request)
    {
        //Paging
        $offset = max(1, $request->get('offset'));
        $nbResult =  max(2, $request->get('nbResult'));
        $totalPage = $repo->findMaxNbOfPage($nbResult);

        if ($offset > $totalPage) {
            throw new Exception("La page n'existe pas.", 404);
        }

        $page = $repo->getMobilePage($offset, $nbResult);

        $normalizer = new Normalizer;
        $pageData = $normalizer->normalize($page, 'list');
        $jsonData = $serializer->serialize($pageData, 'json');

        //Add page's indication
        $pagesIndication [] = ["pageIndication" => "Vous êtes à la page ".$offset." sur ".$totalPage];
        $data = json_encode(array_merge(json_decode($jsonData, true), $pagesIndication));

        $responder = new Responder;
        $response = $responder->createReponse($request, $data, 200);

        return $response;
    }
}
