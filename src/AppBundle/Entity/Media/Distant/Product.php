<?php
namespace AppBundle\Entity\Media\Distant;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Model
 *
 * @ORM\Entity()
 * @ORM\Table(name="p_media_distant")
 */
class Product extends Distant
{

    /**
     * @var \AppBundle\Entity\Product\Product
     *
     * @ORM\ManyToOne(
     *     targetEntity="\AppBundle\Entity\Product\Product",
     *     inversedBy="localMedias")
     */
    private $product;

    public function getProduct()
    {
        return $this->product;
    }
    public function setProduct(\AppBundle\Entity\Product\Product $product)
    {
        $this->product = $product;
    }
}