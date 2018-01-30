<?php
namespace AppBundle\Entity\Guarantee;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductSpecific
 *
 * @ORM\Entity()
 * @ORM\Table(name="feature_guarantee")
 */
class Feature extends Guarantee
{

    /**
     * @var integer|null
     *
     * @ORM\Column(name="productState", type="integer", nullable=true)
     */
    private $productState;

    /**
     * @var \AppBundle\Entity\Feature\Feature
     *
     * @ORM\ManyToOne(
     *     targetEntity="\AppBundle\Entity\Feature\Feature",
     *     inversedBy="guarantees")
     */
    private $feature;

    public function getFeature()
    {
        return $this->feature;
    }

    public function getProductState()
    {
        return $this->productState;
    }
    public function setProductState(int $state)
    {
        $this->productState = $state;
    }

}