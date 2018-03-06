<?php
namespace AppBundle\Action;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Brand Controller
 *
 * Used for additional routes
 *
 * @package AppBundle\Action
 */
class Brand extends Controller
{

    /**
     * List models for specific Brand resource
     *
     * Fetch products with BrandRepository::getModels() and assign them to Brand resource
     *
     * @param \AppBundle\Entity\Product\Brand $brand
     *
     * @return \AppBundle\Entity\Product\Brand
     *
     * @Route(
     *     name="brand_models",
     *     path="/brands/{id}/models",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=AppBundle\Entity\Product\Brand::class, "_api_item_operation_name"="brand_models"}
     * )
     */
    public function brandModelsAction(\AppBundle\Entity\Product\Brand $brand) : \AppBundle\Entity\Product\Brand
    {

        // Get Brand's products
        $models = $this->getDoctrine()->getRepository('AppBundle\Entity\Product\Brand')->getModels($brand->getId());

        // Set found items in Brand object
        $brand->setModels($models);

        // Return Brand Object
        return $brand;
    }

    /**
     * List products for specific Brand object
     *
     * @param \AppBundle\Entity\Product\Brand $brand
     *
     * @return \AppBundle\Entity\Product\Brand
     *
     * @Route(
     *     name="brand_products",
     *     path="/brands/{id}/products",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=AppBundle\Entity\Product\Brand::class, "_api_item_operation_name"="brand_products"}
     * )
     */
    public function brandProductsAction(\AppBundle\Entity\Product\Brand $brand) : \AppBundle\Entity\Product\Brand
    {

        // Get Brand's products
        $products = $this->getDoctrine()->getRepository('AppBundle\Entity\Product\Brand')->getProducts($brand->getId());

        // Set found items in Brand object
        $brand->setProducts($products);

        // Return Brand Object
        return $brand;
    }

    /**
     * List all families for specific Brand
     *
     * @param \AppBundle\Entity\Product\Brand $brand
     *
     * @return \AppBundle\Entity\Product\Brand
     *
     * @Route(
     *     name="brand_families",
     *     path="/brands/{id}/families",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=AppBundle\Entity\Product\Brand::class, "_api_item_operation_name"="brand_families"}
     * )
     */
    public function brandFamiliesAction(\AppBundle\Entity\Product\Brand $brand) : \AppBundle\Entity\Product\Brand
    {

        // Return Brand Object
        return $brand;
    }
}
