<?php

namespace App\Controller;

use App\DTO\CustomerDTO;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Normalizer\Normalizer as Normalizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * Describe the user asked
     * 
     * @Route("/customers/{id}", name="customer_show", methods={"GET"}, requirements={"id"="\d+"})
     * 
     */
    public function showAction(SerializerInterface $serializer, CustomerRepository $repo, $id, UserInterface $user)
    {
        $customer = $repo->findOneByIdCustomUser($id, $user);
        if($customer !== null){
            $customerDTO = new CustomerDTO($customer);
            $data = $serializer->serialize($customerDTO, 'json');
        }
        else{
            throw new NotFoundHttpException("L'utilisateur n'existe pas ou vous n'êtes pas propriétaire de cet utilisateur.");
        }

        return new Response($data, 200, ['Content-Type', 'application/json']);
    }

    /**
     * @Route("/customers", name="customer_list", methods={"GET"})
     */
    public function listAction(SerializerInterface $serializer, CustomerRepository $repo, Request $request, UserInterface $user)
    {
        //Paging
        $offset = max(0, $request->get('offset'));
        $nbResult =  max(2, $request->get('nbResult'));
        $totalPage = $repo->findMaxNbOfPage($nbResult, $user);

        if ($offset > $totalPage || $offset <= 0) {
            throw new NotFoundHttpException("La page n'existe pas");
        }

        $page = $repo->getCustomerPage($offset, $nbResult, $user);

        $normalizer = new Normalizer;
        $data = $normalizer->normalize($page, 'list');
        $jsonData = $serializer->serialize($data, 'json');

        return new Response($jsonData, 200, ['Content-Type', 'application/json']);
    }

    /**
     * @Route("/customers", name="customer_create", methods={"POST"})
     */
    public function createAction(SerializerInterface $serializer, Request $request, EntityManagerInterface $manager)
    {
        $newCustomer = $serializer->deserialize($request->getContent(), Customer::class, 'json');
        $manager->persist($newCustomer);
        $manager->flush();

        return new Response("Utilisateur créé !", 201);
    }

    /**
     * @Route("/customers/{id}", name="customer_update", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function updateAction(SerializerInterface $serializer, Request $request, EntityManagerInterface $manager, CustomerRepository $repo, $id, UserInterface $user)
    {
        $updateCustomer = $serializer->deserialize($request->getContent(), Customer::class, 'json');

        $oldCustomer = $repo->findOneByIdCustomUser($id, $user);

        if ($oldCustomer == null) {
            throw new NotFoundHttpException("L'utilisateur n'existe pas ou vous n'êtes pas propriétaire de cet utilisateur.");
        }

        if($updateCustomer->getLastName() !== null AND $updateCustomer->getLastName() !== $oldCustomer->getLastName()){
            $oldCustomer->setLastName($updateCustomer->getLastName());
        }

        if ($updateCustomer->getFirstName() !== null and $updateCustomer->getFirstName() !== $oldCustomer->getFirstName()) {
            $oldCustomer->setFirstName($updateCustomer->getFirstName());
        }

        if ($updateCustomer->getEmail() !== null and $updateCustomer->getEmail() !== $oldCustomer->getEmail()) {
            $oldCustomer->setEmail($updateCustomer->getEmail());
        }

        $manager->persist($oldCustomer);
        $manager->flush();

        return new Response("Utilisateur mis à jour !", 200);
    }

    /**
     * @Route("/customers/{id}", name="customer_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function deleteAction($id, EntityManagerInterface $manager, CustomerRepository $repo, UserInterface $user)
    {
        $customer = $repo->findOneByIdCustomUser($id, $user);

        if ($customer == null) {
            throw new NotFoundHttpException("L'utilisateur n'existe pas ou vous n'êtes pas propriétaire de cet utilisateur.");
        }
        $manager->remove($customer);
        $manager->flush();

        return new Response("Utilisateur supprimé !", 200);
    }
}

