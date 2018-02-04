<?php

namespace AppBundle\Entity\Media\Local;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Model
 *
 * @ORM\Entity()
 * @ORM\Table(name="pm_media_local")
 */
class Model extends Local
{

    /**
     * @var \AppBundle\Entity\Product\Model
     *
     * @ORM\ManyToOne(
     *     targetEntity="\AppBundle\Entity\Product\Model",
     *     inversedBy="localMedias")
     */
    private $model;

    public function getModel()
    {
        return $this->model;
    }
    public function setModel(\AppBundle\Entity\Product\Model $model)
    {
        $this->model = $model;
    }

}