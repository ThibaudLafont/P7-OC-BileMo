<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 1/28/18
 * Time: 8:05 PM
 */

namespace AppBundle\Entity\Media\Product\Distant;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Media\Distant;

/**
 * Class Model
 *
 * @ORM\Entity()
 * @ORM\Table(name="distant_product")
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