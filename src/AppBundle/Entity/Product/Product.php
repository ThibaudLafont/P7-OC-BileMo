<?php

namespace AppBundle\Entity\Product;

use AppBundle\Entity\Enumerations\ProductCondition;
use AppBundle\Entity\Enumerations\ProductFormatStatus;
use AppBundle\Entity\Enumerations\ProductSoftStatus;
use AppBundle\Entity\Enumerations\ProductState;
use AppBundle\Entity\Guarantee\ProductGlobal;
use AppBundle\Entity\Traits\Hydrate;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * Product Resource
 *
 * @ORM\Table(name="p_product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\ProductRepository")
 */
class Product
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
     * Main title of product
     * @var string
     *
     * Doctrine
     * @ORM\Column(name="title", type="string", length=55)
     *
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "Iphone 5 oxydé"
     *          }
     *     }
     * )
     */
    private $title;

    /**
     * Main description of product
     * @var string
     *
     * Doctrine
     * @ORM\Column(name="description", type="text")
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "Iphone 5 32GB récupéré par Bilemo après un sinistre. Le téléphone présente des traces d'oxydation"
     *          }
     *     }
     * )
     */
    private $description;

    /**
     * Is the product still available
     * @var bool
     *
     * Doctrine
     * @ORM\Column(name="available", type="boolean")
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "boolean",
     *              "example": "true"
     *          }
     *     }
     * )
     */
    private $available;

    /**
     * Price of product
     * @var float
     *
     * Doctrine
     * @ORM\Column(name="price", type="float")
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "float",
     *              "example": "195.99"
     *          }
     *     }
     * )
     */
    private $price;

    /**
     * Physical condition, linked to Enumerations\ProductCondition
     * @var string
     *
     * Doctrine
     * @ORM\Column(name="phy_condition", type="string", length=15)
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "enum"= {"Jamais utilisé", "Comme neuf", "Bon", "Moyen", "Mauvais"},
     *              "example"= "Mauvais"
     *          }
     *     }
     * )
     */
    private $condition;

    /**
     * Sell state of product
     * @var string
     *
     * Doctrine
     * @ORM\Column(name="state", type="string", length=15)
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "name" = "sell_state",
     *              "enum"= {"Neuf", "Reconditionné", "Occasion", "Défectueux"},
     *              "example"= "Défectueux"
     *          }
     *     }
     * )
     */
    private $state;

    /**
     * Text about phone historic
     * @var string|null
     *
     * Doctrine
     * @ORM\Column(name="history", type="text", nullable=true)
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "Le téléphone appartenait à une flotte mobile d'entreprise, le téléphone
     *                          a été racheté à une assurance."
     *          }
     *     }
     * )
     */
    private $history;

    /**
     * IMEI of Product
     * @var int
     *
     * Doctrine
     * @ORM\Column(name="imei", type="bigint")
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "integer",
     *              "example": "12345678912345"
     *          }
     *     }
     * )
     */
    private $imei;

    /**
     * Memory Size in GigaBytes
     * @var int
     *
     * Doctrine
     * @ORM\Column(name="memorySizeInGb", type="integer")
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "integer",
     *              "example": "32"
     *          }
     *     }
     * )
     */
    private $memorySizeInGb;

    /**
     * Color of product
     * @var string
     *
     * Doctrine
     * @ORM\Column(name="color", type="string", length=55)
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "Noir ardoise"
     *          }
     *     }
     * )
     */
    private $color;

    /**
     * Is locked by operator
     * @var bool
     *
     * Doctrine
     * @ORM\Column(name="operator_lock", type="boolean")
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "boolean",
     *              "example": "false"
     *          }
     *     }
     * )
     */
    private $operatorLock;

    /**
     * System version
     * @var string
     *
     * Doctrine
     * @ORM\Column(name="system_version", type="string", length=55)
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example"= "IOS 10.3.3",
     *              "version"= "2.0"
     *          }
     *     }
     * )
     */
    private $systemVersion;

    /**
     * Has been formatted
     * @var bool
     *
     * Doctrine
     * @ORM\Column(name="formatted", type="string")
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "enum" = {"Réinitialisé", "Non réinitialisé", "Inconnu"},
     *              "example": "Inconnu"
     *          }
     *     }
     * )
     */
    private $formatted;

    /**
     * Does product boot properly
     * @var bool
     *
     * Doctrine
     * @ORM\Column(name="boot_properly", type="string")
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "enum" = {"Démarre normalement", "Problème soft", "Brick logiciel - Ne démarre pas", "Non testé / Inconnu"},
     *              "example": "Inconnu"
     *          }
     *     }
     * )
     */
    private $bootProperly;

    /**
     * Product model
     * @var Model
     *
     * Doctrine
     * @ORM\ManyToOne(
     *     targetEntity="Model",
     *     inversedBy="products"
     * )
     */
    private $model;

    /**
     * Notices about product
     * @var Notice
     *
     * Doctrine
     * @ORM\OneToMany(
     *     targetEntity="Notice",
     *     mappedBy="product",
     *     cascade={"persist"}
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "array",
     *              "items"={
     *                  "type"="object",
     *                  "properties"={
     *                      "type"={
     *                          "type"="string",
     *                          "description"="Type of Notice",
     *                          "enum"={"Info", "Alerte"},
     *                          "example"="Alerte"
     *                      },
     *                      "message"={
     *                          "type"="string",
     *                          "description"="Content of Notice",
     *                          "example"="Produit oxydé"
     *                      }
     *                  }
     *              }
     *          }
     *     }
     * )
     */
    private $notices;

    /**
     * Guarantee linked to specific product feature
     * @var array
     *
     * Doctrine
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Guarantee\ProductSpecific",
     *     mappedBy="product"
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "array",
     *              "description"="Contain specific guarantees of resource",
     *              "items" = {
     *                  "type"="object",
     *                  "description"="Specific guarantee, related to product feature",
     *                  "properties"={
     *                      "concern"={
     *                          "type"="string",
     *                          "description"="Concerned feature",
     *                          "example"="main_camera"
     *                      },
     *                      "is_guaranteed"={
     *                          "type"="boolean",
     *                          "description"="True if feature is guaranteed",
     *                          "example"="false"
     *                      },
     *                      "guarantee_length"={
     *                          "type"="float",
     *                          "description"="Guarantee length in month",
     *                          "example"="1.25"
     *                      },
     *                      "message"={
     *                          "type"="string",
     *                          "description"="Information about specific guarantee",
     *                          "example"="Composant HS, non garanti"
     *                      }
     *                  }
     *              }
     *          }
     *     }
     * )
     */
    private $specificGuarantees;

    /**
     * Global product Guarantee
     * @var ProductGlobal
     *
     * Doctrine
     * @ORM\OneToOne(
     *  targetEntity="\AppBundle\Entity\Guarantee\ProductGlobal"
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type"="object",
     *              "description"="Main guarantee of Product",
     *              "properties"={
     *                  "is_guaranteed"={
     *                      "type"="boolean",
     *                      "description"="True if Product is guaranteed",
     *                      "example"="true"
     *                  },
     *                  "guarantee_length"={
     *                      "type"="float",
     *                      "description"="Guarantee length in month",
     *                      "example"="6"
     *                  },
     *                  "message"={
     *                      "type"="string",
     *                      "description"="Information about global guarantee",
     *                      "example"="Ne concerne pas les composants mentionnées dans les garanties spécifiques"
     *                  }
     *              }
     *          }
     *     }
     * )
     */
    private $globalGuarantee;

    // Traits
    use Hydrate;


    // Links

    /**
     * @return string
     */
    private function getSelfLink(){
        return "/products/" . $this->getId();
    }


    // Product normalization

    /**
     * @return array
     */
    public function normalizeProductCollection($links = true, $brand=true, $family=true, $model = true){

        $return = [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'sell_state' => $this->getState(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'available' => $this->getAvailable()
        ];

        if($links)
            $return['_links'] = $this->normalizeProductLinks();


        if($brand || $family || $model)
            $return['embedded'] = $this->normalizeProductEmbedded($brand, $family, $model);

        return $return;
    }

    /**
     * @return array
     */
    public function normalizeProductItem($links = true, $brand=true, $family=true, $model = true){

        // Fill return array with Product properties
        $return = [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'sell_state' => $this->getState(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'available' => $this->getAvailable(),
            'physic_state' => $this->getCondition(),
            'boot_properly' => $this->getBootProperly(),
            'is_formatted' => $this->getFormatted(),
            'history' => $this->getHistory(),
            'imei' => $this->getImei(),
            'color' => $this->getColor(),
            'memory_size' => $this->getMemorySizeInGb(),
            'system_version' => $this->getSystemVersion()
        ];

        // Check & store notices in $return if needed
        if($this->shouldDisplayNotices()){
            $return['notices'] = $this->normalizeProductNotices();
        }

        // Check & store GlobalGuarantee in $return if needed
        if($this->shouldDisplayGlobalGuarantee()){
            $return['global_guarantee'] = $this->normalizeProductGlobalGuarantee();
        }

        // Check & store SpecificGuarantees in $return if needed
        if($this->shouldDisplaySpecificGuarantees()){
            $return['specific_guarantees'] = $this->normalizeProductSpecificGuarantees();
        }

        if($links)
            $return['_links'] = $this->normalizeProductLinks();

        if($brand || $family || $model)
            $return['embedded'] = $this->normalizeProductEmbedded($brand, $family, $model);

        return $return;

    }

    /**
     * @return array
     */
    public function normalizeProductLinks(){

        return [
            '@self' => $this->getSelfLink(),
        ];

    }

    public function normalizeProductEmbedded($brand, $family, $model){

        $return = [];

        if($brand)
            $return['brand'] = $this->getModel()->getFamily()->getBrand()->normalizeBrandCollection(true);
        if($family)
            $return['family'] = $this->getModel()->getFamily()->normalizeFamilyCollection(true, false);
        if($model)
            $return['model'] = $this->getModel()->normalizeModelCollection(true, false, false);

        return $return;

    }


    // Product SubResources

    // Model
    /**
     * @return array
     */
//    public function normalizeProductModel(){
//
//        // Get and store Model Collection
//        $model = $this->getModel()->normalizeModelCollection(true, false, false, false);
//
//        return $model;
//
//    }

//    public function normalizeProductFamily(){
//
//        // Normalize Family
//        $return = $this->getModel()->getFamily()->normalizeFamilyCollection(true, false);
//
//        return $return;
//
//    }

//    public function normalizeProductBrand(){
//
//        // Store product brand
//        $brand = $this->getModel()->getFamily()->normalizeBrand();
//
//        // Normalize Brand
//        $return = $brand->normalizeBrandCollection(true);
//
//        return $return;
//
//    }

    // Notices
    /**
     * Return true if product has notices
     * @return bool
     */
    public function shouldDisplayNotices()
    {
        return $this->getNotices()->count() !== 0;
    }

    /**
     * Normalize Notices
     * @return array
     */
    public function normalizeProductNotices()
    {
        // Fetch and loop on every notices
        foreach($this->getNotices() as $v)
        {
            // Normalize notice and push it in $return
            $return[] = [
                'type' => $v->getType(),
                'content' => $v->getMessage()
            ];
        }

        return $return;
    }

    // Global Guarantees
    /**
     * return true if product have global guarantee
     * @return bool
     */
    public function shouldDisplayGlobalGuarantee(){
        return $this->getGlobalGuarantee() !== null;
    }

    /**
     * Normalize GlobalGuarantee
     * @return array
     */
    public function normalizeProductGlobalGuarantee()
    {
        // Fetch GlobalGuarantee
        $guar = $this->getGlobalGuarantee();

        return [
            'is_guaranteed' => $guar->isGuaranteed(),
            'guarantee_length' => $guar->getLengthInMonth(),
            'message' => $guar->getMessage()
        ];
    }

    // Specifics guarantees
    /**
     * Return true if product has specific(s) guarantee(s)
     * @return bool
     */
    public function shouldDisplaySpecificGuarantees(){
        return $this->getSpecificGuarantees()->count() !== 0;
    }

    /**
     * Normalize specifics guarantees
     * @return array
     */
    public function normalizeProductSpecificGuarantees(){

        // Get product guarantee(s)
        $guars = $this->getSpecificGuarantees();
        // Init empty array
        $return = [];

        // Loop on every guarantee
        foreach($guars as $guar){
            // Build Product normalization
            $return[] = [
                'concern' => $guar->getFeature()->getName(),
                'is_guaranteed' => $guar->isGuaranteed(),
                'guarantee_length' => $guar->getLengthInMonth(),
                'message' => $guar->getMessage()
            ];
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
     * Set title.
     *
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Product
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
     * Set available.
     *
     * @param bool $available
     *
     * @return Product
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available.
     *
     * @return bool
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set price.
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set condition.
     *
     * @param String $condition
     * @return Product
     */
    public function setCondition(String $condition)
    {
        if (!in_array($condition, ProductCondition::getAvailableTypes())) {
            throw new \InvalidArgumentException("Invalid ProductCondition");
        }

        $this->condition = $condition;

        return $this;
    }

    /**
     * Get condition.
     *
     * @return int
     */
    public function getCondition()
    {
        return ProductCondition::getValue($this->condition);
    }

    /**
     * Set state.
     *
     * @param String $state
     *
     * @return Product
     */
    public function setState(String $state)
    {
        if (!in_array($state, ProductState::getAvailableTypes())) {
            throw new \InvalidArgumentException("Invalid ProductState");
        }

        $this->state = $state;

        return $this;
    }

    /**
     * Get state.
     *
     * @return String
     */
    public function getState()
    {
        return ProductState::getValue($this->state);
    }

    /**
     * Set history.
     *
     * @param string|null $history
     *
     * @return Product
     */
    public function setHistory($history = null)
    {
        $this->history = $history;

        return $this;
    }

    /**
     * Get history.
     *
     * @return string|null
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * Set imei.
     *
     * @param int $imei
     *
     * @return Product
     */
    public function setImei($imei)
    {
        $this->imei = $imei;

        return $this;
    }

    /**
     * Get imei.
     *
     * @return int
     */
    public function getImei()
    {
        return $this->imei;
    }

    /**
     * Set memorySizeInGb.
     *
     * @param int $memorySizeInGb
     *
     * @return Product
     */
    public function setMemorySizeInGb($memorySizeInGb)
    {
        $this->memorySizeInGb = $memorySizeInGb;

        return $this;
    }

    /**
     * Get memorySizeInGb.
     *
     * @return int
     */
    public function getMemorySizeInGb()
    {
        return $this->memorySizeInGb;
    }

    /**
     * Set color.
     *
     * @param string $color
     *
     * @return Product
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color.
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    public function getOperatorLock()
    {
        return $this->operatorLock;
    }
    public function setOperatorLock(bool $locked)
    {
        $this->operatorLock = $locked;
    }

    /**
     * Set systemVersion.
     *
     * @param string $systemVersion
     *
     * @return Product
     */
    public function setSystemVersion($systemVersion)
    {
        $this->systemVersion = $systemVersion;

        return $this;
    }

    /**
     * Get systemVersion.
     *
     * @return string
     */
    public function getSystemVersion()
    {
        return $this->systemVersion;
    }

    /**
     * Set formatted.
     *
     * @param string $formatted
     *
     * @return Product
     */
    public function setFormatted($formatted)
    {
        if (!in_array($formatted, ProductFormatStatus::getAvailableTypes())) {
            throw new \InvalidArgumentException("Invalid ProductFormatStatus");
        }

        $this->formatted = $formatted;

        return $this;
    }

    /**
     * Get formatted.
     *
     * @return bool
     */
    public function getFormatted()
    {
        return ProductFormatStatus::getValue($this->formatted);
    }

    /**
     * Set bootProperly.
     *
     * @param string $bootStatus
     *
     * @return Product
     */
    public function setBootProperly($bootStatus)
    {
        if (!in_array($bootStatus, ProductSoftStatus::getAvailableTypes())) {
            throw new \InvalidArgumentException("Invalid ProductSoftStatus");
        }

        $this->bootProperly = $bootStatus;

        return $this;
    }

    /**
     * Get bootProperly.
     *
     * @return bool
     */
    public function getBootProperly()
    {
        return ProductSoftStatus::getValue($this->bootProperly);
    }

    /**
     * Get model
     *
     * @return model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set model
     *
     * @param Model $model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get notices
     *
     * @return Notice
     */
    public function getNotices()
    {
        return $this->notices;
    }

    /**
     * Get specificGuarantees
     *
     * @return \AppBundle\Entity\Feature\ProductTest
     */
    public function getSpecificGuarantees()
    {
        return $this->specificGuarantees;
    }

    /**
     * Set globalGuarantee
     *
     * @param $guarantee
     */
    public function setGlobalGuarantee($guarantee)
    {
        $this->globalGuarantee = $guarantee;
    }

    /**
     * Get globalGuarantee
     *
     * @return ProductGlobal
     */
    public function getGlobalGuarantee()
    {
        return $this->globalGuarantee;
    }

}
