<?php
namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Swagger;
use AppBundle\Entity\Traits\Hydrate;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Brand
 *
 * @package \AppBundle\Entity\Product
 *
 * @ORM\Table(name="p_brand")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\BrandRepository")
 */
class Brand
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
     *          "jsonld_context"={
     *              "@id"="http://schema.org/identifier",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "integer",
     *              "example": "1"
     *          }
     *     }
     * )
     */
    private $id;

    /**
     * Name of Brand
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=55, unique=true)
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="http://schema.org/name",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "Apple"
     *          }
     *     }
     * )
     */
    private $name;

    /**
     * Short description about Brand
     *
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="http://schema.org/description",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "Apple est un constructeur de terminaux informatiques"
     *          }
     *     }
     * )
     */
    private $description;

    /**
     * Brand website home page
     *
     * @var string|null
     *
     * @ORM\Column(name="website_url", type="string", length=255, nullable=true)
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="http://schema.org/url",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "http://apple.com"
     *          }
     *     }
     * )
     */
    private $websiteUrl;

    /**
     * Brand's families
     *
     * @var mixed
     *
     * @ORM\OneToMany(
     *     targetEntity="Family",
     *     mappedBy="brand"
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/category",
     *              "@type"="Product\Family"
     *          },
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
     * Models of Brand resource
     *
     * @var array
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/Product",
     *              "@type"="Product\Model"
     *          },
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
     * Products subresource of Brand
     *
     * @var array
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="http://schema.org/offers",
     *              "@type"="Product\Product"
     *          },
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

    // Brand normalization

    /**
     * Normalize Brand for collection
     *
     * @param $links boolean - Normalize with links or not
     *
     * @return array
     */
    public function normalizeBrandCollection($links = true) : array
    {

        // Base
        $return = [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];

        // If links are wanted, add it to array
        if ($links) {
            $return['_links'] = $this->normalizeBrandLinks();
        }

        return $return;
    }

    /**
     * Normalize Brand for show
     *
     * @param $links boolean - Normalize with links or not
     *
     * @return array
     */
    public function normalizeBrandItem($links = true) : array
    {

        // Base
        $return = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'constructor_url' => $this->getWebsiteUrl()
        ];

        // If links are wanted, add it to array
        if ($links) {
            $return['_links'] = $this->normalizeBrandLinks();
        }

        return $return;
    }


    // Subresource normalization

    /**
     * Brand's products normalization
     *
     * @return array
     */
    public function normalizeBrandProducts() : array
    {

        // Init empty array
        $return = [];

        // loop on every stored products
        foreach ($this->getProducts() as $product) {

            // Add product to return array
            $return[] = $product->normalizeProductCollection(false, false, true, true);
        }

        return $return;
    }

    /**
     * Brand's models normalization
     *
     * @return array
     */
    public function normalizeBrandModels() : array
    {

        //Init empty return array
        $return = [];

        // Loop on every stored models
        foreach ($this->getModels() as $model) {
            $return[] = $model->normalizeModelCollection(true, false, true);
        }

        return $return;
    }

    /**
     * Brand's families normalization
     *
     * @return array
     */
    public function normalizeBrandFamilies() : array
    {

        // Init empty array
        $return = [];

        // Loop on every stored family
        foreach ($this->getFamilies() as $family) {

            // Push new datas in return array
            $return[] = $family->normalizeFamilyCollection(true, false);
        }

        return $return;
    }

    /**
     * Brand's _links normalization
     *
     * @return array
     */
    public function normalizeBrandLinks() : array
    {
        return [
            '@self' => $this->getSelfUrl(),
            '@families' => $this->getFamiliesSubLink(),
            '@models' => $this->getModelsSubLink(),
            '@products' => $this->getProductsSubLink()
        ];
    }


    // Links of Brand

    /**
     * URL to Brand show page
     *
     * @return string
     */
    private function getSelfUrl() : string
    {
        return "/brands/" . $this->getId();
    }

    /**
     * URL to Brand's families subcollection
     *
     * @return string
     */
    private function getFamiliesSubLink() : string
    {
        return '/brands/' . $this->getId() . '/families';
    }

    /**
     * URL to Brand's models subcollection
     *
     * @return string
     */
    private function getModelsSubLink() : string
    {
        return '/brands/' . $this->getId() . '/models';
    }

    /**
     * URL to Brand's products subcollection
     *
     * @return string
     */
    private function getProductsSubLink() : string
    {
        return '/brands/' . $this->getId() . '/products';
    }

    /**
     * Get id.
     *
     * @return int|null
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
    public function setName($name) : Brand
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
     * @param string|null $description
     *
     * @return Brand
     */
    public function setDescription($description = null) : Brand
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
    public function setWebsiteUrl($websiteUrl = null) : Brand
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
     * @return mixed
     */
    public function getFamilies()
    {
        return $this->families;
    }

    /**
     * Get products
     *
     * @return array
     */
    public function getProducts() : array
    {
        return $this->products;
    }

    /**
     * Set Brand's products
     *
     * @param $products
     *
     * @return Brand
     */
    public function setProducts($products) : Brand
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get models
     *
     * @return array
     */
    public function getModels() : array
    {
        return $this->models;
    }

    /**
     * Set Brand's products
     *
     * @param mixed $models
     *
     * @return Brand
     */
    public function setModels($models) : Brand
    {
        $this->models = $models;

        return $this;
    }
}
