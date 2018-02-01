<?php

namespace AppBundle\Entity\Feature;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModelFeature
 */
class ModelFeature
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
     * @var bool
     *
     * @ORM\Column(name="available", type="boolean")
     */
    private $available;

    /**
     * @var Feature
     *
     * @ORM\ManyToOne(
     *     targetEntity="Feature",
     *     inversedBy="models")
     */
    private $feature;

    public function getFeature(){
        return $this->feature;
    }
    public function setFeature(Feature $feature)
    {
        $this->feature = $feature;
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
     * Set available.
     *
     * @param bool $available
     *
     * @return ModelFeature
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available.
     *
     * @return bool
     */
    public function getAvailable()
    {
        return $this->available;
    }

}
