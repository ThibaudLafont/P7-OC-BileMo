<?php

namespace AppBundle\Entity\Product;

use AppBundle\Entity\Feature\SpecValue;
use AppBundle\Entity\Traits\Hydrate;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
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
 *          },
 *          "model_products"={
 *              "method"="GET",
 *              "route_name"="model_products",
 *              "path"="/model/{id}/products",
 *              "normalization_context"={
 *                  "groups"={"model_products"}
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
     * @var string|null
     * Product page on constructor website (if exists)
     *
     * @ORM\Column(name="constructor_url", type="text", nullable=true)
     */
    private $constructorUrl;

    /**
     * @var int
     * Model release year
     *
     * @ORM\Column(name="release_year", type="bigint")
     */
    private $releaseYear;

    /**
     * @var Family
     *
     * @ORM\ManyToOne(
     *     targetEntity="Family",
     *     inversedBy="models"
     * )
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
     */
    private $products;

    // Traits
    use Hydrate;

    public function __construct()
    {
        $this->specValues = new ArrayCollection();
    }


    // Model normalization

    /**
     * @return array
     */
    public function getModelCollection($links = true, $brand = true, $family = true)
    {

        // Properties for Model Collection
        $return = [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];

        // Add links if needed
        if($links) $return['_links'] = $this->getModelLinks();

        // Add embedded resources if needed
        if($brand || $family) // Model's Brand
            $return['_embedded'] = $this->getModelEmbedded($brand, $family);

        return $return;

    }

    /**
     * @return array
     */
    public function getModelItem($links = true, $brand = true, $family = true){

        // Properties for Model Item
        $return = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'release_year' => $this->getReleaseYear(),
            'description' => $this->getDescription(),
            'contructor_url' => $this->getConstructorUrl(),
            'specifications' => $this->getSpecs()
        ];

        // Add links if needed
        if($links) $return['_links'] = $this->getModelLinks();

        // Add embedded resources if needed
        if($brand || $family) // Model's Brand
            $return['_embedded'] = $this->getModelEmbedded($brand, $family);

        return $return;
    }

    // Model subresource

    /**
     * Model's products
     * @return array
     */
    public function getModelProducts(){

        // Init empty array
        $return = [];

        // Loop on every Model's products
        foreach($this->getProducts() as $product){

            // Store ProductSubresource in new $return index
            $return[] = $product->getProductCollection(true, false, false, false);

        }

        return $return;

    }

    public function getSpecs(){

        // Init empty array
        $return = [];

        // Loop on every specValue of object
        foreach($this->getSpecValues() as $specValue){

            // Get Spec object
            $spec = $specValue->getSpec();
            // Get Feature object
            $feature = $spec->getFeature();

            // Store values in correct array index, create it if not set
            $return[$feature->getName()][$spec->getName()] = $specValue->getValue();
        }

        // Return build array
        return $return;

    }

    /**
     * Model _links
     * @return array
     */
    public function getModelLinks(){

        return [
            '@self' => $this->getSelfUrl(),
            '@products' => $this->getProductsSubLink()
        ];

    }

    /**
     * Model _embedded
     * @return array
     */
    public function getModelEmbedded($brand=true, $family=true){

        // Check if brand is required
        if($brand) {
            $return['brand'] =$this->getFamily()->getBrand()->getBrandCollection(true);
        }

        // Check if family is needed
        if($family){
            $return['family'] = $this->getFamily()->getFamilyCollection(true, false);
        }

        return $return;
    }

    // Model links

    /**
     * @return string
     */
    private function getSelfUrl(){
        return "/models/" . $this->getId();
    }

    /**
     * @return string
     */
    private function getProductsSubLink(){
        return "/models/" . $this->getId() . "/products";
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
