<?php
// api/src/Controller/BookSpecial.php

namespace AppBundle\Action;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class Model extends Controller
{


    /**
     * @Route(
     *     name="model_products",
     *     path="/models/{id}/products",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=AppBundle\Entity\Product\Model::class, "_api_item_operation_name"="model_products"}
     * )
     */
    public function modelProductsAction(\AppBundle\Entity\Product\Model $model)
    {

        // Return Brand Object
        return $model;

    }

}