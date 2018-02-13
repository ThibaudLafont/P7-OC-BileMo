<?php

namespace AppBundle\Entity\Feature;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecValue
 * Link model and spec with value
 *
 * @ORM\Table(name="ms_value")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Feature\SpecValueRepository")
 */
class SpecValue
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text")
     */
    private $value;

    /**
     * @var Spec
     * Concerned spec
     *
     * @ORM\ManyToOne(
     *     targetEntity="Spec",
     *     inversedBy="specValues",
     *     cascade={"persist"}
     * )
     */
    private $spec;

    /**
     * @var \AppBundle\Entity\Product\Model
     * Concerned model
     *
     * @ORM\ManyToOne(
     *     targetEntity="\AppBundle\Entity\Product\Model",
     *     inversedBy="specValues",
     *     cascade={"persist"}
     * )
     */
    private $model;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value.
     *
     * @param mixed $value
     *
     * @return SpecValue
     */
    public function setValue($value)
    {
        // Check if value is array
        if(is_array($value)) $value = serialize($value);
        // Check if value is boolean
        if(is_bool($value)) $value = $value ? "true" : "false";

        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return string
     */
    public function getValue()
    {
        // Store value in var
        $value = $this->value;

        // Check if value is serialized
//        if(unserialize($value)) $value = unserialize($value);
        // Check if value is boolean
        if($value === "true") $value = true;
        if($value === "false") $value = false;

        return $value;
    }

    /**
     * Get spec
     *
     * @return Spec
     */
    public function getSpec(){
        return $this->spec;
    }

    /**
     * Set spec
     *
     * @param Spec $spec
     */
    public function setSpec(Spec $spec)
    {
        $this->spec = $spec;
    }

    /**
     * Get model
     *
     * @return \AppBundle\Entity\Product\Model
     */
    public function getModel(): \AppBundle\Entity\Product\Model
    {
        return $this->model;
    }

    /**
     * Set model
     *
     * @param \AppBundle\Entity\Product\Model $model
     */
    public function setModel(\AppBundle\Entity\Product\Model $model)
    {
        $this->model = $model;
    }

}
