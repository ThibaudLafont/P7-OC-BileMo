<?php

namespace AppBundle\Entity\Feature;

use Doctrine\ORM\Mapping as ORM;

/**
 * Spec
 *
 * @ORM\Table(name="f_spec")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Feature\SpecRepository")
 */
class Spec
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Feature
     *
     * @ORM\ManyToOne(
     *     targetEntity="Feature",
     *     inversedBy="specs"
     * )
     */
    private $feature;

    /**
     * @var SpecValue
     *
     * @ORM\OneToMany(
     *     targetEntity="SpecValue",
     *     mappedBy="spec",
     *     cascade={"persist"}
     * )
     */
    private $specValue;


    public function getFeature()
    {
        return $this->feature;
    }
    public function setFeature(Feature $feature)
    {
        $this->feature = $feature;
    }

    public function getSpecValue()
    {
        return $this->specValue;
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
     * Set name.
     *
     * @param string $name
     *
     * @return Spec
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
