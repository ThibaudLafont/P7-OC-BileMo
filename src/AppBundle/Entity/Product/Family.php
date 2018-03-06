<?php
namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Family
 *
 * @package AppBundle\Entity\Product
 *
 * @ORM\Table(name="p_family")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\FamilyRepository")
 */
class Family
{

    /**
     * Primary key of resource
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "integer",
     *              "example": "1"
     *          }
     *     }
     * )
     */
    private $id;

    /**
     * Name of Family
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=55)
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "Iphone"
     *          }
     *     }
     * )
     */
    private $name;

    /**
     * Short description about Family
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "Iphone représente la gamme smartphone d'Apple"
     *          }
     *     }
     * )
     */
    private $description;

    /**
     * Family Brand
     *
     * @var Brand
     *
     * @ORM\ManyToOne(
     *     targetEntity="Brand",
     *     inversedBy="families"
     * )
     */
    private $brand;

    /**
     * Family models
     *
     * @var array
     *
     * @ORM\OneToMany(
     *     targetEntity="Model",
     *     mappedBy="family"
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "array",
     *              "items"={
     *                  "$ref"="#/definitions/Model-model_list"
     *              }
     *          }
     *     }
     * )
     */
    private $models;

    /**
     * Family's products
     *
     * @var array
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "array",
     *              "items"={
     *                  "$ref"="#/definitions/Model-model_list"
     *              }
     *          }
     *     }
     * )
     */
    private $products;


    // Family normalization

    /**
     * Family normalization for collection
     *
     * @param $links boolean -Normalize with _links or not
     * @param $embedded boolean -Normalize with _embedded or not
     *
     * @return array
     */
    public function normalizeFamilyCollection($links = true, $embedded = true) : array
    {

        // Family's Collection attributes
        $return = [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];

        // Add links if needed
        if($links) $return['_links'] = $this->normalizeFamilyLinks();

        // Add embedded if needed
        if($embedded) $return['_embedded'] = $this->normalizeFamilyEmbedded();

        return $return;

    }

    /**
     * Family normalization for item show
     *
     * @param $links boolean -Normalize with _links or not
     * @param $embedded boolean -Normalize with _embedded or not
     *
     * @return array
     */
    public function normalizeFamilyItem($links = true, $embedded = true) : array
    {

        // Family's Item attributes
        $return = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription()
        ];

        // Add links if needed
        if($links) $return['_links'] = $this->normalizeFamilyLinks();

        // Add embedded if needed
        if($embedded) $return['_embedded'] = $this->normalizeFamilyEmbedded();

        return $return;
    }


    // Family Subresources

    /**
     * Family models normalization
     *
     * @return array
     */
    public function normalizeFamilyModels() : array
    {

        // Init empty array
        $return = [];

        // Loop on every Family's models
        foreach($this->getModels() as $model){

            // Store Model Collection in return array
            $return[] = $model->normalizeModelCollection(true, false, false);

        }

        return $return;

    }

    /**
     * Family products normalization
     *
     * @return array
     */
    public function normalizeFamilyProducts() : array
    {

        // Init empty array
        $return = [];

        foreach($this->getProducts() as $product){

            // Store every found product in return array
            $return[] = $product->normalizeProductCollection(true, false, false, true);

        }

        return $return;

    }

    /**
     * Family _links
     *
     * @return array
     */
    public function normalizeFamilyLinks() : array
    {

        return [
            '@self' => $this->getSelfUrl(),
            '@models' => $this->getModelsSubLink(),
            '@products' => $this->getProductsSubLink()
        ];

    }

    /**
     * Family _embedded
     *
     * @return array
     */
    public function normalizeFamilyEmbedded() : array
    {

        $return['brand'] = $this->getBrand()->normalizeBrandCollection(true);

        return $return;

    }


    // Links of Family

    /**
     * URL to show item
     *
     * @return string
     */
    private function getSelfUrl() : string
    {
        return "/families/" . $this->getId();
    }

    /**
     * URL to Family models subresource
     *
     * @return string
     */
    private function getModelsSubLink() : string
    {
        return "/families/" . $this->getId() . "/models";
    }

    /**
     * URL to Family products subresource
     *
     * @return string
     */
    private function getProductsSubLink() : string
    {
        return "/families/" . $this->getId() . "/products";
    }


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
     * @return Family
     */
    public function setName(string $name) : Family
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
     * Set description.
     *
     * @param string $description
     *
     * @return Family
     */
    public function setDescription(string $description) : Family
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * Get brand
     *
     * @return Brand
     */
    public function getBrand() : Brand
    {
        return $this->brand;
    }

    /**
     * Set brand
     *
     * @param Brand $brand
     *
     * @return Family
     */
    public function setBrand(Brand $brand) : Family
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get models
     *
     * @return array
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * Get Family products
     *
     * @return array
     */
    public function getProducts() : array
    {
        return $this->products;
    }

    /**
     * Set products
     *
     * @param mixed $products
     *
     * @return Family
     */
    public function setProducts($products) : Family
    {
        $this->products = $products;

        return $this;
    }

}
