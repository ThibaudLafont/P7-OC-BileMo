<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 1/28/18
 * Time: 7:54 PM
 */

namespace AppBundle\Entity\Guarantee;

use AppBundle\Entity\Feature\Feature;
use AppBundle\Entity\Product\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductSpecific
 *
 * @ORM\Entity()
 * @ORM\Table(name="p_specific_guarantee")
 */
class ProductSpecific extends Guarantee
{

    /**
     * @var Feature
     *
     * @ORM\ManyToOne
     * (
     *      targetEntity="\AppBundle\Entity\Feature\Feature",
     *      inversedBy="productGarantees"
     * )
     */
    private $feature;

    /**
     * @var Product
     *
     * @ORM\ManyToOne
     * (
     *      targetEntity="\AppBundle\Entity\Product\Product",
     *      inversedBy="specificGarantees"
     * )
     */
    private $product;

    public function productSpecificGuaranteeToArray(){
        return [
            'concern' => $this->getFeature()->getName(),
            'is_guaranteed' => $this->isGuaranteed(),
            'length_in_month' => $this->getLengthInMonth(),
            'message' => $this->getMessage()
        ];
    }

    /**
     * Get feature
     *
     * @return mixed
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * Set feature
     *
     * @param \AppBundle\Entity\Feature\Feature $feature
     */
    public function setFeature(Feature $feature)
    {
        $this->feature = $feature;
    }

    /**
     * Get product
     *
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set product
     *
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

}