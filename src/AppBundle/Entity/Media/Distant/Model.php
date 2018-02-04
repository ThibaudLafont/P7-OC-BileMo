<?php
namespace AppBundle\Entity\Media\Distant;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Model
 *
 * @ORM\Entity()
 * @ORM\Table(name="pm_media_distant")
 */
class Model extends Distant
{

    /**
     * @var \AppBundle\Entity\Product\Model
     *
     * @ORM\ManyToOne(
     *     targetEntity="\AppBundle\Entity\Product\Model",
     *     inversedBy="distantMedias")
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