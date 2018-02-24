<?php

namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Family
 *
 * @ApiResource(
 *     collectionOperations={
 *          "family_list"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"family_list"}
 *              }
 *          }
 *     },
 *     itemOperations={
 *          "family_show"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"family_show"}
 *              }
 *          },
 *          "family_models"={
 *              "method"="GET",
 *              "route_name"="family_models",
 *              "path"="/families/{id}/models",
 *              "normalization_context"={
 *                  "groups"={"family_models"}
 *              }
 *          },
 *          "family_products"={
 *              "method"="GET",
 *              "route_name"="family_products",
 *              "path"="/families/{id}/products",
 *              "normalization_context"={
 *                  "groups"={"family_products"}
 *              }
 *          }
 *     }
 * )
 *
 * @ORM\Table(name="p_family")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\FamilyRepository")
 */
class Family
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
     * @var string
     *
     * @ORM\Column(name="description", type="text")
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
     * @var Model
     * Family's models
     *
     * @ORM\OneToMany(
     *     targetEntity="Model",
     *     mappedBy="family"
     * )
     */
    private $models;

    /**
     * @var array
     */
    private $products;


    // Links of Family

    /**
     * @return string
     */
    public function getSelfUrl(){
        return "/families/" . $this->getId();
    }

    /**
     * @return string
     */
    public function getModelsSubLink(){
        return "/families/" . $this->getId() . "/models";
    }

    /**
     * @return string
     */
    public function getProductsSubLink(){
        return "/families/" . $this->getId() . "/products";
    }


    // Family normalization

    /**
     * Collection normalization
     * @return array
     */
    public function getFamilyCollection(){
        return [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];
    }

    /**
     * Item normalization
     * @return array
     */
    public function getFamilyItem(){
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription()
        ];
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
        $return['brand'] = $this->getBrand()->getBrandCollection();
        $return['brand']['_links'] = $this->getBrand()->getBrandLinks();

        return $return;
    }


    // Family Subresources

    /**
     * Family's models
     * @return array
     */
    public function getFamilyModels(){
        $return = [];
        foreach($this->getModels() as $model){
            $return[] = $model->getModelSubResource();
        }
        return $return;
    }

    /**
     * Family's products
     * @return array
     */
    public function getFamilyProducts(){
        $return = [];
        foreach($this->getProducts() as $product){
            $return[] = $product->getProductSubResource(false, false, true);
        }
        return $return;
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
