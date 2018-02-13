<?php

namespace AppBundle\Entity\Product;

use AppBundle\Entity\Feature\SpecValue;
use AppBundle\Entity\Traits\Hydrate;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @Groups({"brand_show", "family_show", "model_list", "model_show"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=55)
     *
     * @Groups({"brand_show", "family_show", "model_list", "model_show"})
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Groups({"model_show"})
     */
    private $description;

    /**
     * @var string|null
     * Product page on constructor website (if exists)
     *
     * @ORM\Column(name="constructor_url", type="text", nullable=true)
     * @Groups({"model_show"})
     */
    private $constructorUrl;

    /**
     * @var int
     * Model release year
     *
     * @ORM\Column(name="release_year", type="bigint")
     * @Groups("model_show")
     */
    private $releaseYear;

    /**
     * @var Family
     *
     * @ORM\ManyToOne(
     *     targetEntity="Family",
     *     inversedBy="models"
     * )
     * @Groups({"model_list", "model_show"})
     */
    private $family;

    /**
     * @var ArrayCollection
     * Models values to features specifications
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Feature\SpecValue",
     *     mappedBy="model",
     *     cascade={"persist"}
     * )
     */
    private $specValues;

    /**
     * @var Product
     * Products of this model
     *
     * @ORM\OneToMany(
     *     targetEntity="Product",
     *     mappedBy="model"
     * )
     * @Groups({"model_show"})
     */
    private $products;

    // Traits
    use Hydrate;

    public function __construct()
    {
        $this->specValues = new ArrayCollection();
    }

    /**
     * @Groups({"model_list", "model_show"})
     */
    public function getBrand(){
        // Fetch brand from model family
        $brand = $this->getFamily()->getBrand();

        // Build and return array
        return [
            'id' => $brand->getId(),
            'name' => $brand->getName(),
            '@show' => $brand->getShowUrl()
        ];
    }

    /**
     * @Groups({"brand_show", "family_show", "model_list"})
     */
    public function getShowUrl(){
        return "/models/" . $this->getId();
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
     * Get constructorUrl
     *
     * @return null|string
     */
    public function getConstructorUrl(): string
    {
        return $this->constructorUrl;
    }

    /**
     * Set constructorUrl
     *
     * @param null|string $constructorUrl
     */
    public function setConstructorUrl(string $constructorUrl)
    {
        $this->constructorUrl = $constructorUrl;
    }

    /**
     * Get releaseYear
     *
     * @return int
     */
    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    /**
     * Set releaseYear
     *
     * @param int $releaseYear
     */
    public function setReleaseYear(int $releaseYear)
    {
        $this->releaseYear = $releaseYear;
    }

    /**
     * Get family
     *
     * @return Family
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * Set family
     *
     * @param Family
     */
    public function setFamily(Family $family)
    {
        $this->family = $family;
    }

    /**
     * Get specValues
     *
     * @return array
     */
    public function getSpecValues()
    {
        return $this->specValues;
    }

    /**
     * Get products
     *
     * @return Product
     */
    public function getProducts()
    {
        return $this->products;
    }

}
