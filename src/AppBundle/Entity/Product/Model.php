<?php

namespace AppBundle\Entity\Product;

use AppBundle\Entity\Feature\SpecValue;
use AppBundle\Entity\Traits\Hydrate;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * Model
 *
 * @ApiResource(
 *     collectionOperations={
 *          "model_list"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"model_list"}
 *              }
 *          }
 *     },
 *     itemOperations={
 *          "model_show"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"model_show"}
 *              }
 *          }
 *     }
 * )
 *
 * @ORM\Table(name="p_model")
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
     *
     * @Groups("brand_show")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=55)
     *
     * @Groups("brand_show")
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="constructor_url", type="text", nullable=true)
     */
    private $constructorUrl;

    /**
     * @var int
     *
     * @ORM\Column(name="release_year", type="bigint")
     * @Groups("model_list")
     */
    private $releaseYear;

    /**
     * @var \AppBundle\Entity\Media\Local\Model
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Media\Local\Model",
     *     mappedBy="model"
     * )
     */
    private $localMedias;

    /**
     * @var \AppBundle\Entity\Media\Distant\Model
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Media\Distant\Model",
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

    /**
     * @var SpecValue
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Feature\SpecValue",
     *     mappedBy="spec",
     *     cascade={"persist"}
     * )
     */
    private $specValue;

    use Hydrate;

    public function getSpecValue()
    {
        return $this->specValue;
    }


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
    public function setFamily($family)
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

    /**
     * @return null|string
     */
    public function getConstructorUrl(): string
    {
        return $this->constructorUrl;
    }

    /**
     * @param null|string $constructorUrl
     */
    public function setConstructorUrl(string $constructorUrl)
    {
        $this->constructorUrl = $constructorUrl;
    }

    /**
     * @return int
     */
    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    /**
     * @param int $releaseYear
     */
    public function setReleaseYear(int $releaseYear)
    {
        $this->releaseYear = $releaseYear;
    }
}
