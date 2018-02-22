<?php
// api/src/Controller/BookSpecial.php

namespace AppBundle\Action;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class Family extends Controller
{


    /**
     * @Route(
     *     name="family_models",
     *     path="/families/{id}/models",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=AppBundle\Entity\Product\Family::class, "_api_item_operation_name"="family_models"}
     * )
     */
    public function familyModelsAction(\AppBundle\Entity\Product\Family $family)
    {

        // Return Brand Object
        return $family;

    }
    /**
     * @Route(
     *     name="family_products",
     *     path="/families/{id}/products",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=AppBundle\Entity\Product\Family::class, "_api_item_operation_name"="family_products"}
     * )
     */
    public function familyProductsAction(\AppBundle\Entity\Product\Family $family)
    {

        // Get Brand's products
        $products = $this->getDoctrine()->getRepository('AppBundle\Entity\Product\Family')->getProducts($family->getId());

        // Set found items in Brand object
        $family->setProducts($products);

        // Return Brand Object
        return $family;

    }

}