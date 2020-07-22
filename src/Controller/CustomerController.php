<?php

namespace App\Controller;

use Exception;
use App\Responder;
use App\DTO\CustomerDTO;
use App\Entity\Customer;
use App\Normalizer as Normalizer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\HATEOAS\CustomerHATEOASGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerController extends AbstractController
{
    /**
     * Describe the user asked
     *
     * @Route("/customers/{id}", name="customer_show", methods={"GET"}, requirements={"id"="\d+"})
     *
     */
    public function showAction(SerializerInterface $serializer, CustomerRepository $repo, UserInterface $user, UrlGeneratorInterface$router, Request $request)
    {
        $id = $request->get('id');
        $customer = $repo->findOneByIdCustomUser($id, $user);

        if ($customer == null) {
            throw new Exception("L'utilisateur n'existe pas ou vous n'êtes pas propriétaire de cet utilisateur.", Response::HTTP_NOT_FOUND);
        }

        //Add links
        $HATEOASGenerator = new CustomerHATEOASGenerator($router, $customer);
        $HATEOASGenerator->listLink();
        $HATEOASGenerator->modifyLink();
        $HATEOASGenerator->deleteLink();

        //Create Customer DTO
        $customerDTO = new CustomerDTO($customer);
        $data = $serializer->serialize($customerDTO, 'json');

        $responder = new Responder;
        $response = $responder->createReponse($request, $data, Response::HTTP_OK);

        return $response;
    }

    /**
     * @Route("/customers", name="customer_list", methods={"GET"})
     */
    public function listAction(SerializerInterface $serializer, CustomerRepository $repo, Request $request, UserInterface $user)
    {
        //Paging
        $offset = max(1, $request->get('offset'));
        $nbResult =  max(2, $request->get('nbResult'));
        $totalPage = $repo->findMaxNbOfPage($nbResult, $user);

        if ($offset > $totalPage) {
            throw new Exception("La page n'existe pas.", Response::HTTP_NOT_FOUND);
        }

        $page = $repo->getCustomerPage($offset, $nbResult, $user);

        $normalizer = new Normalizer;
        $pageData = $normalizer->normalize($page, 'list');
        $jsonData = $serializer->serialize($pageData, 'json');

        //Add page's indication
        $pagesIndication[] = ["pageIndication" => "Vous êtes à la page " . $offset . " sur " . $totalPage];
        $data = json_encode(array_merge(json_decode($jsonData, true), $pagesIndication));

        $responder = new Responder;
        $response = $responder->createReponse($request, $data, Response::HTTP_OK);

        return $response;
    }

    /**
     * @Route("/customers", name="customer_create", methods={"POST"})
     */
    public function createAction(SerializerInterface $serializer, Request $request, EntityManagerInterface $manager, UrlGeneratorInterface $router, UserInterface $user, ValidatorInterface $validator)
    {
        $newCustomer = $serializer->deserialize($request->getContent(), Customer::class, 'json');
        $newCustomer->setUser($user);

        $errors = $validator->validate($newCustomer);
        if (count($errors) > 0) {
            $errorsString = "";
            foreach ($errors as $error) {
                $errorsString .= "- " . $error->getMessage(). " ";
            }
            throw new Exception($errorsString, Response::HTTP_NOT_FOUND);
        }

        $manager->persist($newCustomer);
        $manager->flush();

        //Add links
        $HATEOASGenerator = new CustomerHATEOASGenerator($router, $newCustomer);
        $HATEOASGenerator->selfLink();
        $HATEOASGenerator->modifyLink();
        $HATEOASGenerator->deleteLink();

        //Create Customer DTO
        $customerDTO = new CustomerDTO($newCustomer);
        $data = $serializer->serialize($customerDTO, 'json');

        $responder = new Responder;
        $response = $responder->createReponse($request, $data, Response::HTTP_CREATED);

        return $response;
    }

    /**
     * @Route("/customers/{id}", name="customer_update", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function updateAction(SerializerInterface $serializer, Request $request, EntityManagerInterface $manager, CustomerRepository $repo, UserInterface $user, UrlGeneratorInterface $router)
    {
        $updateCustomer = $serializer->deserialize($request->getContent(), Customer::class, 'json');
        $id = $request->get('id');

        $oldCustomer = $repo->findOneByIdCustomUser($id, $user);
        if ($oldCustomer == null) {
            throw new Exception("L'utilisateur n'existe pas ou vous n'êtes pas propriétaire de cet utilisateur.", Response::HTTP_NOT_FOUND);
        }
        
        if ($updateCustomer->getLastName() !== null) {
            $oldCustomer->setLastName($updateCustomer->getLastName());
        }

        if ($updateCustomer->getFirstName() !== null) {
            $oldCustomer->setFirstName($updateCustomer->getFirstName());
        }

        if ($updateCustomer->getEmail() !== null) {
            $oldCustomer->setEmail($updateCustomer->getEmail());
        }

        $manager->persist($oldCustomer);
        $manager->flush();

        //Add links
        $HATEOASGenerator = new CustomerHATEOASGenerator($router, $oldCustomer);
        $HATEOASGenerator->selfLink();
        $HATEOASGenerator->deleteLink();

        //Create Customer DTO
        $customerDTO = new CustomerDTO($oldCustomer);
        $data = $serializer->serialize($customerDTO, 'json');

        $responder = new Responder;
        $response = $responder->createReponse($request, $data, Response::HTTP_OK);

        return $response;
    }

    /**
     * @Route("/customers/{id}", name="customer_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function deleteAction(Request $request, EntityManagerInterface $manager, CustomerRepository $repo, UserInterface $user)
    {
        $id = $request->get('id');
        $customer = $repo->findOneByIdCustomUser($id, $user);

        if ($customer == null) {
            throw new Exception("L'utilisateur n'existe pas ou vous n'êtes pas propriétaire de cet utilisateur.", Response::HTTP_NOT_FOUND);
        }

        $manager->remove($customer);
        $manager->flush();

        $responder = new Responder;
        $response = $responder->createReponse($request, "Utilisateur supprimé !", Response::HTTP_OK);
        return $response;
    }
}
