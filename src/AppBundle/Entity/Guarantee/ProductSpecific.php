<?php
namespace AppBundle\Entity\Guarantee;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Feature\Feature;
use AppBundle\Entity\Product\Product;

/**
 * Class ProductSpecific
 *
 * @package \AppBundle\Entity\Guarantee
 *
 * @ORM\Entity()
 * @ORM\Table(name="p_specific_guarantee")
 */
class ProductSpecific extends Guarantee
{

    /**
     * Concerned Feature
     *
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
     * Concerned Product
     *
     * @var Product
     *
     * @ORM\ManyToOne
     * (
     *      targetEntity="\AppBundle\Entity\Product\Product",
     *      inversedBy="specificGuarantees"
     * )
     */
    private $product;

    /**
     * Normalize ProductSpecific
     *
     * @return array
     */
    public function productSpecificGuaranteeToArray() : array
    {
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
    public function getFeature() : Feature
    {
        return $this->feature;
    }

    /**
     * Set feature
     *
     * @param \AppBundle\Entity\Feature\Feature $feature
     *
     * @return ProductSpecific
     */
    public function setFeature(Feature $feature) : ProductSpecific
    {
        $this->feature = $feature;

        return $this;
    }

    /**
     * Get product
     *
     * @return Product
     */
    public function getProduct() : Product
    {
        return $this->product;
    }

    /**
     * Set product
     *
     * @param Product $product
     *
     * @return ProductSpecific
     */
    public function setProduct(Product $product) : ProductSpecific
    {
        $this->product = $product;

        return $this;
    }

}
