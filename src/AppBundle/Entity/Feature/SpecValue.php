<?php

namespace AppBundle\Entity\Feature;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecValue
 *
 * @ORM\Table(name="feature_spec_value")
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
     *
     * @ORM\ManyToOne(
     *     targetEntity="Spec",
     *     inversedBy="specValue",
     *     cascade={"persist"}
     * )
     */
    private $spec;

    /**
     * @var \AppBundle\Entity\Product\Model
     *
     * @ORM\ManyToOne(
     *     targetEntity="\AppBundle\Entity\Product\Model",
     *     inversedBy="specValue",
     *     cascade={"persist"}
     * )
     */
    private $model;

    public function getSpec(){
        return $this->spec;
    }
    public function setSpec(Spec $spec)
    {
        $this->spec = $spec;
    }

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
        if(is_array($value)) $value = serialize($value);
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
        return $this->value;
    }

    /**
     * @return \AppBundle\Entity\Product\Model
     */
    public function getModel(): \AppBundle\Entity\Product\Model
    {
        return $this->model;
    }

    /**
     * @param \AppBundle\Entity\Product\Model $model
     */
    public function setModel(\AppBundle\Entity\Product\Model $model)
    {
        $this->model = $model;
    }
}
