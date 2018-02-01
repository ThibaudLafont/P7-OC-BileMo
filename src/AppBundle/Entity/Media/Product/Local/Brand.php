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
 * @ORM\Table(name="local_brand")
 */
class Brand extends Local
{

    /**
     * @var \AppBundle\Entity\Product\Brand
     *
     * @ORM\ManyToOne(
     *     targetEntity="\AppBundle\Entity\Product\Brand",
     *     inversedBy="distantMedias")
     */
    private $brand;

    public function getBrand()
    {
        return $this->brand;
    }
    public function setFamily(\AppBundle\Entity\Product\Brand $brand)
    {
        $this->brand = $brand;
    }

}