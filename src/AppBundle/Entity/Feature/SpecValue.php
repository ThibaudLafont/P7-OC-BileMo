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
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @var Spec
     *
     * @ORM\ManyToOne(
     *     targetEntity="Spec",
     *     inversedBy="specValue")
     */
    private $spec;

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
     * @param string $value
     *
     * @return SpecValue
     */
    public function setValue($value)
    {
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
}
