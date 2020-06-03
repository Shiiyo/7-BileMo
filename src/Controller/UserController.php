<?php

namespace App\Controller;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Normalizer\Normalizer as Normalizer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/users", name="user_list", methods={"GET"})
     */
    public function listAction(SerializerInterface $serializer, UserRepository $repo)
    {
        $users = $repo->findAll();

        $normalizer = new Normalizer;

        $data = $normalizer->normalize($users, 'list');
        $jsonData = $serializer->serialize($data, 'json');

        return new Response($jsonData, 200, ['Content-Type', 'application/json']);
    }

    /**
     * @Route("/users", name="user_create", methods={"POST"})
     */
    public function createAction(SerializerInterface $serializer, Request $request, EntityManagerInterface $manager)
    {
        $newUser = $serializer->deserialize($request->getContent(), User::class, 'json');
        $manager->persist($newUser);
        $manager->flush();

        return new Response("User created !", 201);
    }

    /**
     * @Route("/users/{id}", name="user_update", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function updateAction(SerializerInterface $serializer, Request $request, EntityManagerInterface $manager, UserRepository $repo, $id)
    {
        $updateUser = $serializer->deserialize($request->getContent(), User::class, 'json');

        $oldUser = $repo->findOneById($id);

        if($updateUser->getLastName() !== null AND $updateUser->getLastName() !== $oldUser->getLastName()){
            $oldUser->setLastName($updateUser->getLastName());
        }

        if ($updateUser->getFirstName() !== null and $updateUser->getFirstName() !== $oldUser->getFirstName()) {
            $oldUser->setFirstName($updateUser->getFirstName());
        }

        if ($updateUser->getEmail() !== null and $updateUser->getEmail() !== $oldUser->getEmail()) {
            $oldUser->setEmail($updateUser->getEmail());
        }

        $manager->persist($oldUser);
        $manager->flush();

        return new Response("User updated !", 200);
    }

    /**
     * @Route("/users/{id}", name="user_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function deleteAction($id, EntityManagerInterface $manager, UserRepository $repo)
    {
        $user = $repo->findOneById($id);
        $manager->remove($user);
        $manager->flush();

        return new Response("User deleted !", 200);
    }
}

