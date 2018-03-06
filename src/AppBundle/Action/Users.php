<?php
// api/src/Controller/BookSpecial.php

namespace AppBundle\Action;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Users Controller
 *
 * Used for additional routes
 *
 * @package AppBundle\Action
 */
class Users extends Controller
{

    /**
     * List all Users for specific Company resource
     *
     * @param \AppBundle\Entity\User\Company $company
     *
     * @return \AppBundle\Entity\User\Company
     *
     * @Route(
     *     name="company_users",
     *     path="/companies/{id}/clients",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=AppBundle\Entity\User\Company::class, "_api_item_operation_name"="company_users"}
     * )
     */
    public function companyUsersAction(\AppBundle\Entity\User\Company $company) : \AppBundle\Entity\User\Company
    {

        // Return Brand Object
        return $company;

    }

    /**
     * Fetch and assemble all Users (Partner and Client)
     *
     * @return Response
     *
     * @Route(
     *     name="user_list",
     *     path="/users",
     *     methods={"GET"}
     * )
     */
    public function allUsersAction() : Response
    {

        $clients = $this->getDoctrine()->getRepository("AppBundle:User\Client")->findAll();
        $partners = $this->getDoctrine()->getRepository("AppBundle:User\Partner")->findAll();

        $serializer = $this->get('serializer');

        $normalize['clients'] = $clients;
        $normalize['partners'] = $partners;

        $response = $serializer->serialize($normalize, 'json', ['groups' => ['client_list']]);

        return new Response($response, 200, ['Content-Type' => 'application/ld+json; charset=utf-8']);
    }

}
