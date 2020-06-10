<?php

namespace App\Controller;

use App\DTO\CustomerDTO;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Normalizer\Normalizer as Normalizer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customers/{id}", name="customer_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function showAction(SerializerInterface $serializer, CustomerRepository $repo, $id)
    {
        $customer = $repo->findOneById($id);
        $customerDTO = new CustomerDTO($customer);

        $data = $serializer->serialize($customerDTO, 'json');

        return new Response($data, 200, ['Content-Type', 'application/json']);
    }

    /**
     * @Route("/customers", name="customer_list", methods={"GET"})
     */
    public function listAction(SerializerInterface $serializer, CustomerRepository $repo)
    {
        $customers = $repo->findAll();
        $normalizer = new Normalizer;

        $data = $normalizer->normalize($customers, 'list');
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

        return new Response("Customer created !", 201);
    }

    /**
     * @Route("/customers/{id}", name="customer_update", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function updateAction(SerializerInterface $serializer, Request $request, EntityManagerInterface $manager, CustomerRepository $repo, $id)
    {
        $updateCustomer = $serializer->deserialize($request->getContent(), Customer::class, 'json');

        $oldCustomer = $repo->findOneById($id);

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

        return new Response("Customer updated !", 200);
    }

    /**
     * @Route("/customers/{id}", name="customer_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function deleteAction($id, EntityManagerInterface $manager, CustomerRepository $repo)
    {
        $customer = $repo->findOneById($id);
        $manager->remove($customer);
        $manager->flush();

        return new Response("Customer deleted !", 200);
    }
}

