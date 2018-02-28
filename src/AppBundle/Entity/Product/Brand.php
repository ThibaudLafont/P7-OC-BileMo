<?php
namespace AppBundle\Entity\Product;

use AppBundle\Entity\Traits\Hydrate;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Swagger;

/**
 * Brand
 *
 * @ORM\Table(name="p_brand")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\BrandRepository")
 */
class Brand
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
     * Name of Brand
     *
     * @ORM\Column(name="name", type="string", length=55, unique=true)
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "Apple"
     *          }
     *     }
     * )
     */
    private $name;

    /**
     * @var string|null
     * Short description about Brand resource
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "Apple est un constructeur de terminaux informatiques"
     *          }
     *     }
     * )
     */
    private $description;

    /**
     * @var string|null
     * Brand home page
     *
     * @ORM\Column(name="website_url", type="string", length=255, nullable=true)
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "http://apple.com"
     *          }
     *     }
     * )
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
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "array",
     *              "items"={
     *                  "$ref"="#/definitions/Family-family_list"
     *              }
     *          }
     *     }
     * )
     */
    private $families;

    /**
     * @var array
     * Models of Brand resource
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
     * Products subresource of Brand
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "array",
     *              "items"={
     *                  "$ref"="#/definitions/Product-product_list"
     *              }
     *          }
     *     }
     * )
     */
    private $products;

    // Traits
    use Hydrate;

    public function __construct(){
        $this->models = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    // Brand normalization

    /**
     * @return array
     */
    public function getBrandCollection($links = true){

        $return = [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];

        if($links) $return['_links'] = $this->getBrandLinks();

        return $return;

    }

    /**
     * @return array
     */
    public function getBrandItem($links = true){

        $return = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'constructor_url' => $this->getWebsiteUrl()
        ];

        if($links) $return['_links'] = $this->getBrandLinks();

        return $return;

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
            $return[] = $product->getProductCollection(false, false, true, true);

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

            $return[] = $model->getModelCollection(true, false, true);

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

            // Push new datas in return array
            $return[] = $family->getFamilyCollection(true, false);

        }

        return $return;
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


    // Links of Brand

    /**
     * @return string
     */
    private function getSelfUrl(){
        return "/brands/" . $this->getId();
    }

    /**
     * @return string
     */
    private function getFamiliesSubLink(){
        return '/brands/' . $this->getId() . '/families';
    }

    /**
     * @return string
     */
    private function getModelsSubLink(){
        return '/brands/' . $this->getId() . '/models';
    }

    /**
     * @return string
     */
    private function getProductsSubLink(){
        return '/brands/' . $this->getId() . '/products';
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
     * @return mixed
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
