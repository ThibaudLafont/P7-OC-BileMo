<?php

namespace AppBundle\Entity\Feature;

use AppBundle\Entity\Traits\Hydrate;
use Doctrine\ORM\Mapping as ORM;

/**
 * SpecValue
 *
 * Link model and spec with value
 *
 * @package AppBundle\Entity\Feature
 *
 * @ORM\Table(name="ms_value")
 * @ORM\Entity()
 */
class SpecValue
{
    /**
     * Primary key of resource
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Value of Model for Spec
     *
     * @var mixed
     *
     * @ORM\Column(name="value", type="text")
     */
    private $value;

    /**
     * Concerned Spec
     *
     * @var Spec
     *
     * @ORM\ManyToOne(
     *     targetEntity="Spec",
     *     inversedBy="specValues",
     *     cascade={"persist"}
     * )
     */
    private $spec;

    /**
     * Concerned Model
     *
     * @var \AppBundle\Entity\Product\Model
     *
     * @ORM\ManyToOne(
     *     targetEntity="\AppBundle\Entity\Product\Model",
     *     inversedBy="specValues",
     *     cascade={"persist"}
     * )
     */
    private $model;

    // Traits
    use Hydrate;

    /**
     * Get id.
     *
     * @return int|null
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
    public function setValue($value) : SpecValue
    {
        // Check if value is boolean
        if (is_bool($value)) {
            $value = $value ? "true" : "false";
        }

        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return mixed
     */
    public function getValue()
    {
        // Store value in var
        $value = $this->value;

        // Check if value is boolean
        if ($value === "true") {
            $value = true;
        } elseif ($value === "false") {
            $value = false;
        }

        return $value;
    }

    /**
     * Get spec
     *
     * @return Spec
     */
    public function getSpec() : Spec
    {
        return $this->spec;
    }

    /**
     * Set spec
     *
     * @param Spec $spec
     *
     * @return SpecValue
     */
    public function setSpec(Spec $spec) : SpecValue
    {
        $this->spec = $spec;

        return $this;
    }

    /**
     * Get model
     *
     * @return \AppBundle\Entity\Product\Model
     */
    public function getModel() : \AppBundle\Entity\Product\Model
    {
        return $this->model;
    }

    /**
     * Set model
     *
     * @param \AppBundle\Entity\Product\Model $model
     *
     * @return SpecValue
     */
    public function setModel(\AppBundle\Entity\Product\Model $model)
    {
        $this->model = $model;

        return $this;
    }
}
