<?php

namespace AppBundle\Entity\Feature;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feature
 *
 * @ORM\Table(name="f_feature")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Feature\FeatureRepository")
 */
class Feature
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Spec",
     *     mappedBy="feature"
     * )
     */
    private $specs;

    /**
     * @var \AppBundle\Entity\Product\Model
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Product\Model",
     *     mappedBy="feature"
     * )
     */
    private $models;

    /**
     * @var ProductTest
     *
     * @ORM\OneToMany(
     *     targetEntity="Test",
     *     mappedBy="feature"
     * )
     */
    private $tests;

    /**
     * @var \AppBundle\Entity\Feature\ProductTest
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Guarantee\ProductSpecific",
     *     mappedBy="feature"
     * )
     */
    private $specificGuarantees;

    public function getSpecs()
    {
        return $this->specs;
    }

    public function getModels(){
        return $this->models;
    }

    public function getTests()
    {
        return $this->tests;
    }

    public function getSpecificGuarantees()
    {
        return $this->specificGuarantees;
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
     * @return Feature
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
