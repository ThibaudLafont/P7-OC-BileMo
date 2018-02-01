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
 */
class Family 
{

    /**
     * @var \AppBundle\Entity\Product\Family
     *
     * @ORM\ManyToOne(
     *     targetEntity="\AppBundle\Entity\Product\Family",
     *     inversedBy="localMedias")
     */
    private $family;

    public function getFamily()
    {
        return $this->family;
    }
    public function setFamily(\AppBundle\Entity\Product\Family $family)
    {
        $this->family = $family;
    }

}