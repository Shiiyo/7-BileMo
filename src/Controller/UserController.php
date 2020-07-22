<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="user_create", methods={"POST"})
     */
    public function createAction(SerializerInterface $serializer, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $newUser = $serializer->deserialize($request->getContent(), User::class, 'json');

        //Hash password
        $plainPassword = $newUser->getPassword();
        $hashPassword = $encoder->encodePassword($newUser, $plainPassword);
        $newUser->setPassword($hashPassword);

        $manager->persist($newUser);
        $manager->flush();

        return new Response("User created !", Response::HTTP_CREATED);
    }
}
