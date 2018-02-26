<?php

namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Family
 *
 * @ORM\Table(name="p_family")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\FamilyRepository")
 */
class Family
{
    /**
     * @var int
     * Primary key of resource
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
     * @var string
     * Name of Family
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
     * @var Brand
     * Family's brand
     *
     * @ORM\ManyToOne(
     *     targetEntity="Brand",
     *     inversedBy="families"
     * )
     */
    private $brand;

    /**
     * @var array
     * Family's models
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
     * @var array
     * Family's products
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
     * Collection normalization
     * @return array
     */
    public function getFamilyCollection($links = true, $embedded = true){

        // Family's Collection attributes
        $return = [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];

        // Add links if needed
        if($links) $return['_links'] = $this->getFamilyLinks();

        // Add embedded if needed
        if($embedded) $return['_embedded'] = $this->getFamilyEmbedded();

        return $return;

    }

    /**
     * Item normalization
     * @return array
     */
    public function getFamilyItem($links = true, $embedded = true){

        // Family's Item attributes
        $return = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription()
        ];

        // Add links if needed
        if($links) $return['_links'] = $this->getFamilyLinks();

        // Add embedded if needed
        if($embedded) $return['_embedded'] = $this->getFamilyEmbedded();

        return $return;
    }


    // Family Subresources

    /**
     * Family's models
     * @return array
     */
    public function getFamilyModels(){

        // Init empty array
        $return = [];

        // Loop on every Family's models
        foreach($this->getModels() as $model){

            // Store Model Collection in return array
            $return[] = $model->getModelCollection(true, false, false);

        }

        return $return;

    }

    /**
     * Family's products
     * @return array
     */
    public function getFamilyProducts(){

        // Init empty array
        $return = [];

        foreach($this->getProducts() as $product){

            // Store every found product in return array
            $return[] = $product->getProductCollection(true, false, false, true);

        }

        return $return;

    }

    /**
     * Family _links
     * @return array
     */
    public function getFamilyLinks()
    {

        return [
            '@self' => $this->getSelfUrl(),
            '@models' => $this->getModelsSubLink(),
            '@products' => $this->getProductsSubLink()
        ];

    }

    /**
     * Family _embedded
     * @return mixed
     */
    public function getFamilyEmbedded()
    {

        $return['brand'] = $this->getBrand()->getBrandCollection(true);

        return $return;

    }


    // Links of Family

    /**
     * @return string
     */
    private function getSelfUrl(){
        return "/families/" . $this->getId();
    }

    /**
     * @return string
     */
    private function getModelsSubLink(){
        return "/families/" . $this->getId() . "/models";
    }

    /**
     * @return string
     */
    private function getProductsSubLink(){
        return "/families/" . $this->getId() . "/products";
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
     * @return Family
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
     * @param string $description
     *
     * @return Family
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get brand
     *
     * @return Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set brand
     *
     * @param Brand $brand
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Get models
     *
     * @return Model
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

}
