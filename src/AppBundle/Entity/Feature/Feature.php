<?php

namespace AppBundle\Entity\Feature;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups({"product_show"})
     */
    private $name;

    /**
     * @var Array
     * Sub index for feature specifications
     *
     * @ORM\OneToMany(
     *     targetEntity="Spec",
     *     mappedBy="feature"
     * )
     */
    private $specs;

    /**
     * @var Array
     * Allow to link a test to a product feature
     *
     * @ORM\OneToMany(
     *     targetEntity="Test",
     *     mappedBy="feature"
     * )
     */
    private $tests;

    /**
     * @var Array
     * Allow to set a specific guarantee on a product composant
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Guarantee\ProductSpecific",
     *     mappedBy="feature"
     * )
     */
    private $specificGuarantees;
  
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

    /**
     * Get specs
     *
     * @return mixed
     */
    public function getSpecs()
    {
        return $this->specs;
    }

    /**
     * Get tests
     *
     * @return array
     */
    public function getTests()
    {
        return $this->tests;
    }

    /**
     * Get specificGuarantees
     *
     * @return Array
     */
    public function getSpecificGuarantees()
    {
        return $this->specificGuarantees;
    }

}
