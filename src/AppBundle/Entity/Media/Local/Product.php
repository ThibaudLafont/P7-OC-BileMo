<?php
namespace AppBundle\Entity\Media\Local;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Model
 *
 * @ORM\Entity()
 * @ORM\Table(name="p_media_local")
 */
class Product extends Local
{

    /**
     * @var \AppBundle\Entity\Product\Product
     *
     * @ORM\ManyToOne(
     *     targetEntity="\AppBundle\Entity\Product\Product",
     *     inversedBy="distantMedias")
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