<?php
// api/src/Controller/BookSpecial.php

namespace AppBundle\Action;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class Users extends Controller
{


    /**
     * @Route(
     *     name="company_users",
     *     path="/companies/{id}/users",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=AppBundle\Entity\User\Company::class, "_api_item_operation_name"="company_users"}
     * )
     */
    public function modelProductsAction(\AppBundle\Entity\User\Company $company)
    {

        // Return Brand Object
        return $company;

    }

}