<?php
namespace AppBundle\Action;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Model Controller
 *
 * Used for additional routes
 *
 * @package AppBundle\Action
 */
class Model extends Controller
{

    /**
     * List all Products for specific Model resource
     *
     * @param \AppBundle\Entity\Product\Model $model
     *
     * @return \AppBundle\Entity\Product\Model
     *
     * @Route(
     *     name="model_products",
     *     path="/models/{id}/products",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=AppBundle\Entity\Product\Model::class, "_api_item_operation_name"="model_products"}
     * )
     */
    public function modelProductsAction(\AppBundle\Entity\Product\Model $model) : \AppBundle\Entity\Product\Model
    {

        // Return Brand Object
        return $model;

    }

}
