<?php

namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model
 *
 * @ORM\Table(name="product_model")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\ModelRepository")
 */
class Model
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
     * @ORM\Column(name="name", type="string", length=55)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \AppBundle\Entity\Media\Product\Local\Model
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Media\Product\Local\Model",
     *     mappedBy="model"
     * )
     */
    private $localMedias;

    /**
     * @var \AppBundle\Entity\Media\Product\Distant\Model
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Media\Product\Distant\Model",
     *     mappedBy="model"
     * )
     */
    private $distantMedias;

    /**
     * @var Brand
     *
     * @ORM\ManyToOne(
     *     targetEntity="Family",
     *     inversedBy="models"
     * )
     */
    private $family;

    /**
     * @var Product
     *
     * @ORM\OneToMany(
     *     targetEntity="Product",
     *     mappedBy="model"
     * )
     */
    private $products;

    /**
     * @var Brand
     *
     * @ORM\ManyToOne(
     *     targetEntity="Brand",
     *     inversedBy="models")
     */
    private $brand;

    public function getLocalMedias()
    {
        return $this->localMedias;
    }
    public function getDistantMedias()
    {
        return $this->distantMedias;
    }

    public function getFamily()
    {
        return $this->family;
    }
    public function setFamily(Family $family)
    {
        $this->family = $family;
    }

    public function getBrand()
    {
        return $this->brand;
    }
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function getProducts()
    {
        return $this->products;
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
     * @return Model
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
     * Set description.
     *
     * @param string|null $description
     *
     * @return Model
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }
}
