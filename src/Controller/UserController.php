<?php

namespace App\Controller;

use App\DTO\UserDTO;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/users/{id}", name="user_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function showAction(SerializerInterface $serializer, UserRepository $repo, $id)
    {
        $user = $repo->findOneById($id);
        $userDTO = new UserDTO($user);

        $data = $serializer->serialize($userDTO, 'json');

        return new Response($data, 200, ['Content-Type', 'application/json']);
    }
}

