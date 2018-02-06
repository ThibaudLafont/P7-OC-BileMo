<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 1/28/18
 * Time: 7:54 PM
 */

namespace AppBundle\Entity\Guarantee;

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
     * @ORM\ManyToOne
     * (
     *      targetEntity="\AppBundle\Entity\Feature\Feature",
     *      inversedBy="productGarantees"
     * )
     */
    private $feature;

    /**
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

    public function getFeature()
    {
        return $this->feature;
    }
    public function setFeature(\AppBundle\Entity\Feature\Feature $feature)
    {
        $this->feature = $feature;
    }
    public function getProduct()
    {
        return $this->product;
    }
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

}