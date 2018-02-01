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
 * @ORM\Table(name="media_model_local")
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