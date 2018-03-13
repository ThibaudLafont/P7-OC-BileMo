<?php

namespace AppBundle\Entity\Feature;

use AppBundle\Entity\Traits\Hydrate;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Spec
 *
 * @package AppBundle\Entity\Feature
 *
 * @ORM\Table(name="f_spec")
 * @ORM\Entity()
 */
class Spec
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
     * Name of Spec
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * Feature of Spec
     *
     * @var Feature
     *
     * @ORM\ManyToOne(
     *     targetEntity="Feature",
     *     inversedBy="specs"
     * )
     */
    private $feature;

    /**
     * Link model value for this spec
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="SpecValue",
     *     mappedBy="spec",
     *     cascade={"persist"}
     * )
     */
    private $specValues;

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
     * Set name.
     *
     * @param string $name
     *
     * @return Spec
     */
    public function setName(string $name) : Spec
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get feature
     *
     * @return Feature
     */
    public function getFeature() : Feature
    {
        return $this->feature;
    }

    /**
     * Set feature
     *
     * @param Feature $feature
     *
     * @return Spec
     */
    public function setFeature(Feature $feature) : Spec
    {
        $this->feature = $feature;

        return $this;
    }

    /**
     * Get specValue
     *
     * @return ArrayCollection
     */
    public function getSpecValues()
    {
        return $this->specValues;
    }
}
