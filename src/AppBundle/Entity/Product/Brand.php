<?php

namespace AppBundle\Entity\Product;

use AppBundle\Entity\Traits\Hydrate;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Swagger;

/**
 * Brand
 *
 * @ApiResource(
 *     collectionOperations={
 *          "brand_list"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"brand_list"}
 *              }
 *          }
 *     },
 *     itemOperations={
 *          "brand_show"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"brand_show"}
 *              }
 *          },
 *          "brand_families"={
 *              "method"="GET",
 *              "route_name"="brand_families",
 *              "path"="/brands/{id}/families",
 *              "normalization_context"={
 *                  "groups"={"brand_families"}
 *              }
 *          },
 *          "brand_products"={
 *              "method"="GET",
 *              "route_name"="brand_products",
 *              "path"="/brands/{id}/products",
 *              "normalization_context"={
 *                  "groups"={"brand_products"}
 *              }
 *          },
 *          "brand_models"={
 *              "method"="GET",
 *              "route_name"="brand_models",
 *              "path"="/brands/{id}/models",
 *              "normalization_context"={
 *                  "groups"={"brand_models"}
 *              }
 *          }
 *     }
 * )
 *
 * @ORM\Table(name="p_brand")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\BrandRepository")
 */
class Brand
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
     * @ORM\Column(name="name", type="string", length=55, unique=true)
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
     * Brand home page
     *
     * @ORM\Column(name="website_url", type="string", length=255, nullable=true)
     */
    private $websiteUrl;

    /**
     * @var array
     * Brand's families
     *
     * @ORM\OneToMany(
     *     targetEntity="Family",
     *     mappedBy="brand"
     * )
     */
    private $families;

    /**
     * @var array
     */
    private $products;

    /**
     * @var array
     */
    private $models;

    // Traits
    use Hydrate;


    // Links of Brand

    /**
     * @return string
     */
    public function getSelfUrl(){
        return "/brands/" . $this->getId();
    }

    /**
     * @return string
     */
    public function getFamiliesSubLink(){
        return '/brands/' . $this->getId() . '/families';
    }

    /**
     * @return string
     */
    public function getModelsSubLink(){
        return '/brands/' . $this->getId() . '/models';
    }

    /**
     * @return string
     */
    public function getProductsSubLink(){
        return '/brands/' . $this->getId() . '/products';
    }

    /**
     * Brand's _links
     * @return array
     */
    public function getBrandLinks(){
        return [
            '@self' => $this->getSelfUrl(),
            '@families' => $this->getFamiliesSubLink(),
            '@models' => $this->getModelsSubLink(),
            '@products' => $this->getProductsSubLink()
        ];
    }


    // Brand normalization

    /**
     * @return array
     */
    public function getBrandCollection(){
        return [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];
    }

    /**
     * @return array
     */
    public function getBrandItem(){
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'constructor_url' => $this->getWebsiteUrl()
        ];
    }


    // Subresource normalization

    /**
     * Brand's products
     * @return array
     */
    public function getBrandProducts(){

        // Init empty array
        $return = [];

        // loop on every stored products
        foreach($this->getProducts() as $product){

            // Add product to return array
            $return[] = $product->getProductSubResource(false, true, true);

        }

        return $return;

    }

    /**
     * Brand's models
     * @return array
     */
    public function getBrandModels(){

        //Init empty return array
        $return = [];

        // Loop on every stored models
        foreach($this->getModels() as $model){

            // Normalize family
            $family = $model->getFamily()->getFamilyCollection();
            $family['_links'] = $model->getFamily()->getFamilyLinks();

            // Normalize model
            $insert = $model->getModelCollection();
            $insert['_links'] = $model->getModelLinks();

            // Assembly fetched datas
            $insert['_embedded']['family'] = $family;

            // Push new model in return array
            $return[] = $insert;
        }

        return $return;
    }

    /**
     * Brand's families
     * @return array
     */
    public function getBrandFamilies(){

        // Init empty array
        $return = [];

        // Loop on every stored family
        foreach($this->getFamilies() as $family){

            // Store Family Collection array
            $insert = $family->getFamilyCollection();

            // Store Family links
            $insert['_links'] = $family->getFamilyLinks();

            // Push new datas in return array
            $return[] = $insert;

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
     * @return Brand
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
     * @return Brand
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
     * Set websiteUrl.
     *
     * @param string|null $websiteUrl
     *
     * @return Brand
     */
    public function setWebsiteUrl($websiteUrl = null)
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    /**
     * Get websiteUrl.
     *
     * @return string|null
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * Get families
     *
     * @return array
     */
    public function getFamilies()
    {
        return $this->families;
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    public function setProducts($products){
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @param mixed $models
     */
    public function setModels($models)
    {
        $this->models = $models;
    }

}
