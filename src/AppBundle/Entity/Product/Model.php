<?php
namespace AppBundle\Entity\Product;

use AppBundle\Entity\Feature\SpecValue;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;
use AppBundle\Entity\Traits\Hydrate;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model
 *
 * @package AppBundle\Entity\Product
 *
 * @ORM\Table(name="p_model")
 * @ORM\Entity()
 */
class Model
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
     * Model name
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=55)
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="http://schema.org/name",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "Iphone 5"
     *          }
     *     }
     * )
     */
    private $name;

    /**
     * Description of model
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
     *              "type" = "integer",
     *              "example": "Dernier modèle avant changement de design"
     *          }
     *     }
     * )
     */
    private $description;

    /**
     * Product page on constructor website (if exists)
     *
     * @var string|null
     *
     * @ORM\Column(name="constructor_url", type="text", nullable=true)
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="http://schema.org/url",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "https://apple.com/iphone-5"
     *          }
     *     }
     * )
     */
    private $constructorUrl;

    /**
     * Model release year
     *
     * @var int
     *
     * @ORM\Column(name="release_year", type="bigint")
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/releaseDate",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "integer",
     *              "example": "2015"
     *          }
     *     }
     * )
     */
    private $releaseYear;

    /**
     * Family of Model
     *
     * @var Family
     *
     * @ORM\ManyToOne(
     *     targetEntity="Family",
     *     inversedBy="models"
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/category",
     *              "@type"="Product\Family"
     *          }
     *     }
     * )
     */
    private $family;

    /**
     * Models values for features specifications
     *
     * @var mixed
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Feature\SpecValue",
     *     mappedBy="model",
     *     cascade={"persist"}
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="http://schema.org/Thing",
     *              "@type"="Model\Spec"
     *          }
     *     }
     * )
     */
    private $specValues;

    /**
     * Products of this model
     *
     * @var mixed
     *
     * @ORM\OneToMany(
     *     targetEntity="Product",
     *     mappedBy="model"
     * )
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
     *                  "$ref"="#/definitions/Model-model_list"
     *              }
     *          }
     *     }
     * )
     */
    private $products;

    // Traits
    use Hydrate;


    // Model normalization

    /**
     * Normalize Model for collection
     *
     * @param bool $links -Normalize with _links
     * @param bool $brand -Normalize with _embedded[brand]
     * @param bool $family -Normalize with _embedded[family]
     *
     * @return array
     */
    public function normalizeModelCollection($links = true, $brand = true, $family = true) : array
    {

        // Properties for Model Collection
        $return = [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];

        // Add links if needed
        if ($links) {
            $return['_links'] = $this->normalizeModelLinks();
        }

        // Add embedded resources if needed
        if ($brand || $family) { // Model's Brand
            $return['_embedded'] = $this->normalizeModelEmbedded($brand, $family);
        }

        return $return;
    }

    /**
     * Normalize Model for item
     *
     * @param bool $links -Normalize with _links
     * @param bool $brand -Normalize with _embedded[brand]
     * @param bool $family -Normalize with _embedded[family]
     *
     * @return array
     */
    public function normalizeModelItem($links = true, $brand = true, $family = true) : array
    {

        // Properties for Model Item
        $return = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'release_year' => $this->getReleaseYear(),
            'description' => $this->getDescription(),
            'contructor_url' => $this->getConstructorUrl(),
            'specifications' => $this->normalizeSpecs()
        ];

        // Add links if needed
        if ($links) {
            $return['_links'] = $this->normalizeModelLinks();
        }

        // Add embedded resources if needed
        if ($brand || $family) { // Model's Brand
            $return['_embedded'] = $this->normalizeModelEmbedded($brand, $family);
        }

        return $return;
    }

    // Model subresource

    /**
     * Model's products normalization
     *
     * @return array
     */
    public function normalizeModelProducts() : array
    {

        // Init empty array
        $return = [];

        // Loop on every Model's products
        foreach ($this->getProducts() as $product) {

            // Store ProductSubresource in new $return index
            $return[] = $product->normalizeProductCollection(true, false, false, false);
        }

        return $return;
    }

    /**
     * Specifications of Model resource
     *
     * @return array
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "array",
     *              "example"=
     *                  {
     *                      "main_camera"= {
     *                          "resolution"="8MPX",
     *                          "flash"="true"
     *                      }
     *                  }
     *          }
     *     }
     * )
     */
    private function normalizeSpecs() : array
    {

        // Init empty array
        $return = [];

        // Loop on every specValue of object
        foreach ($this->getSpecValues() as $specValue) {

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
     * Model _links normalization
     *
     * @return array
     */
    public function normalizeModelLinks() : array
    {
        return [
            '@self' => $this->getSelfUrl(),
            '@products' => $this->getProductsSubLink()
        ];
    }

    /**
     * Model _embedded normalization
     *
     * @param bool $brand -Normalize with _embedded[brand]
     * @param bool $family -Normalize with _embedded[family]
     *
     * @return array|null
     */
    public function normalizeModelEmbedded($brand=true, $family=true)
    {

        // Check if brand is required
        if ($brand) {
            $return['brand'] =$this->getFamily()->getBrand()->normalizeBrandCollection(true);
        }

        // Check if family is needed
        if ($family) {
            $return['family'] = $this->getFamily()->normalizeFamilyCollection(true, false);
        }

        return $return;
    }

    // Model links

    /**
     * Get URL to item
     *
     * @return string
     */
    private function getSelfUrl() : string
    {
        return "/models/" . $this->getId();
    }

    /**
     * Get URL to Model Products subresource
     *
     * @return string
     */
    private function getProductsSubLink() : string
    {
        return "/models/" . $this->getId() . "/products";
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
     * @return Model
     */
    public function setName(string $name) : Model
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
     * @return Model
     */
    public function setDescription($description = null) : Model
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
     *
     * @return Model
     */
    public function setConstructorUrl(string $constructorUrl) : Model
    {
        $this->constructorUrl = $constructorUrl;

        return $this;
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
     *
     * @return Model
     */
    public function setReleaseYear(int $releaseYear) : Model
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    /**
     * Get family
     *
     * @return Family
     */
    public function getFamily() : Family
    {
        return $this->family;
    }

    /**
     * Set family
     *
     * @param Family
     *
     * @return Model
     */
    public function setFamily(Family $family) : Model
    {
        $this->family = $family;

        return $this;
    }

    /**
     * Get specValues
     *
     * @return mixed
     */
    public function getSpecValues()
    {
        return $this->specValues;
    }

    /**
     * Get products
     *
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }
}
