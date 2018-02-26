<?php
// api/src/Controller/BookSpecial.php

namespace AppBundle\Action;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Users extends Controller
{


    /**
     * @Route(
     *     name="company_users",
     *     path="/companies/{id}/clients",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=AppBundle\Entity\User\Company::class, "_api_item_operation_name"="company_users"}
     * )
     */
    public function companyUsersAction(\AppBundle\Entity\User\Company $company)
    {

        // Return Brand Object
        return $company;

    }

    /**
     * @Route(
     *     name="all_users",
     *     path="/users",
     *     methods={"GET"}
     * )
     */
    public function allUsersAction(){

        $clients = $this->getDoctrine()->getRepository("AppBundle:User\Client")->findAll();
        $partners = $this->getDoctrine()->getRepository("AppBundle:User\Partner")->findAll();

        $serializer = $this->get('serializer');

        $normalize['clients'] = $clients;
        $normalize['partners'] = $partners;

        $response = $serializer->serialize($normalize, 'json', ['groups' => ['client_list']]);

        return new Response($response, 200, ['Content-Type' => 'application/ld+json; charset=utf-8']);
    }

}