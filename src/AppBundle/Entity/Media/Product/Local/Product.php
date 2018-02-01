<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 1/28/18
 * Time: 8:05 PM
 */

namespace AppBundle\Entity\Media\Product\Local;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Media\Local;

/**
 * Class Model
 *
 * @ORM\Entity()
 * @ORM\Table(name="media_product_local")
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