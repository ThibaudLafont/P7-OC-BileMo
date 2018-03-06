<?php

namespace AppBundle\Repository\Product;

/**
 * FamilyRepository
 *
 * @package AppBundle\Repository\Product
 */
class FamilyRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * Retrieve all Products of specific Family resource
     *
     * @param int $id -Family id
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
            WHERE f.id = :family_id
        ";

        // Execute the query and store results
        $models = $this->getEntityManager()
            ->createQuery($state)
            ->setParameter('family_id', $id)
            ->getResult();

        // Return the products
        return $models;
    }
}
