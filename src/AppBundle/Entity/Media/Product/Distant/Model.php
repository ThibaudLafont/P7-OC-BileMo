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
 * @ORM\Table(name="media_model_distant")
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