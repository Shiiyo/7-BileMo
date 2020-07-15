<?php

namespace App\Controller;

use Exception;
use App\DTO\MobileDTO;
use App\Normalizer as Normalizer;
use App\Repository\MobileRepository;
use App\HATEOAS\MobileHATEOASGenerator;
use App\Responder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MobileController extends AbstractController
{
    /**
     * @Route("/mobiles/{id}", name="mobile_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function showAction(SerializerInterface $serializer, MobileRepository $repo, $id, UrlGeneratorInterface$router, Request $request)
    {
        try {
            $mobile = $repo->findOneById($id);

            if ($mobile === null) {
                throw new Exception("Ce mobile n'existe pas.");
            }
        } catch (Exception $e) {
            $response = new Response("Erreur: " . $e->getMessage(), 404, [], true);
            return $response;
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
        $offset = max(0, $request->get('offset'));
        $nbResult =  max(2, $request->get('nbResult'));
        $totalPage = $repo->findMaxNbOfPage($nbResult);

        try {
            if ($offset > $totalPage || $offset <= 0) {
                throw new Exception("La page n'existe pas.");
            }
        } catch (Exception $e) {
            $response = new Response("Erreur: " . $e->getMessage(), 404, [], true);
            return $response;
        }

        $page = $repo->getMobilePage($offset, $nbResult);

        $normalizer = new Normalizer;
        $data = $normalizer->normalize($page, 'list');
        $jsonData = $serializer->serialize($data, 'json');

        $responder = new Responder;
        $response = $responder->createReponse($request, $jsonData, 200);

        return $response;
    }
}
