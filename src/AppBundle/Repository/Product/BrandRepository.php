<?php
namespace AppBundle\Repository\Product;

/**
 * BrandRepository
 *
 * @package AppBundle\Repository\Product
 */
class BrandRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * Retrieve all Products of specific Brand resource by id
     *
     * @param $id int -Id of target Brand
     * @return mixed
     */
    public function getProducts(int $id)
    {

        // DQL statement fetching all brand's products
        $state = "
            SELECT p
            FROM AppBundle:Product\Product p
            JOIN p.model m 
            JOIN m.family f 
            JOIN f.brand b 
            WHERE b.id = :brand_id
        ";

        // Execute the query and store results
        $products = $this->getEntityManager()
            ->createQuery($state)
            ->setParameter('brand_id', $id)
            ->getResult();

        // Return the products
        return $products;

    }

    /**
     * Retrieve all Products of specific Brand resource by id
     *
     * @param $id int -Id of target Brand
     * @return mixed
     */
    public function getModels(int $id)
    {

        // DQL statement fetching all brand's products
        $state = "
            SELECT m
            FROM AppBundle:Product\Model m
            JOIN m.family f 
            JOIN f.brand b 
            WHERE b.id = :brand_id
        ";

        // Execute the query and store results
        $models = $this->getEntityManager()
            ->createQuery($state)
            ->setParameter('brand_id', $id)
            ->getResult();

        // Return the products
        return $models;

    }

}
