<?php
namespace AppBundle\Entity\Feature;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Feature
 *
 * @package AppBundle\Entity\Feature
 *
 * @ORM\Table(name="f_feature")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Feature\FeatureRepository")
 */
class Feature
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
     * Name of Feature
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Groups({"product_show"})
     */
    private $name;

    /**
     * Feature specifications
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Spec",
     *     mappedBy="feature"
     * )
     */
    private $specs;

    /**
     * Link Feature and Product with specific guarantee
     *
     * @var ArrayCollection
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
    public function getId() : int
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
    public function setName(string $name)
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
     * Get specs
     *
     * @return ArrayCollection
     */
    public function getSpecs() : ArrayCollection
    {
        return $this->specs;
    }

    /**
     * Get specificGuarantees
     *
     * @return ArrayCollection
     */
    public function getSpecificGuarantees() : ArrayCollection
    {
        return $this->specificGuarantees;
    }

}
