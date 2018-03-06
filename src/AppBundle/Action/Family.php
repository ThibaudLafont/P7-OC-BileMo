<?php
namespace AppBundle\Action;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Family Controller
 *
 * Used for additional routes
 *
 * @package AppBundle\Action
 */
class Family extends Controller
{

    /**
     * List models for specific Family resource
     *
     * @param \AppBundle\Entity\Product\Family $family
     *
     * @return \AppBundle\Entity\Product\Family
     *
     * @Route(
     *     name="family_models",
     *     path="/families/{id}/models",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=AppBundle\Entity\Product\Family::class, "_api_item_operation_name"="family_models"}
     * )
     */
    public function familyModelsAction(\AppBundle\Entity\Product\Family $family) : \AppBundle\Entity\Product\Family
    {

        // Return Brand Object
        return $family;

    }

    /**
     * List Products for specific Family resource
     *
     * Fetch Products though FamilyRepository::getProducts and assign them to Family
     *
     * @param \AppBundle\Entity\Product\Family $family
     *
     * @return \AppBundle\Entity\Product\Family
     *
     * @Route(
     *     name="family_products",
     *     path="/families/{id}/products",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=AppBundle\Entity\Product\Family::class, "_api_item_operation_name"="family_products"}
     * )
     */
    public function familyProductsAction(\AppBundle\Entity\Product\Family $family) : \AppBundle\Entity\Product\Family
    {

        // Get Brand's products
        $products = $this->getDoctrine()->getRepository('AppBundle\Entity\Product\Family')->getProducts($family->getId());

        // Set found items in Brand object
        $family->setProducts($products);

        // Return Brand Object
        return $family;

    }

}
