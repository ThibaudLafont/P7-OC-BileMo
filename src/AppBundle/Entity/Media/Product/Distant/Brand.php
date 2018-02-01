<?php
namespace AppBundle\Entity\Media\Product\Distant;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Media\Distant;

/**
 * Class Model
 */
class Brand 
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