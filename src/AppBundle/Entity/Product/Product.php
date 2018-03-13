<?php
namespace AppBundle\Entity\Product;

use AppBundle\Entity\Enumerations\PhysicState;
use AppBundle\Entity\Enumerations\SellState;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Enumerations\ProductCondition;
use AppBundle\Entity\Enumerations\ProductFormatStatus;
use AppBundle\Entity\Enumerations\ProductSoftStatus;
use AppBundle\Entity\Enumerations\ProductState;
use AppBundle\Entity\Guarantee\ProductGlobal;
use AppBundle\Entity\Traits\Hydrate;

/**
 * Product Resource
 *
 * @package AppBundle\Entity\Product
 *
 * @ORM\Table(name="p_product")
 * @ORM\Entity()
 */
class Product
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
     * Main title of product
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=55)
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="http://schema.org/name",
     *              "@type"="@id"
     *          },
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
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="http://schema.org/description",
     *              "@type"="@id"
     *          },
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
     *
     * @var bool
     *
     * @ORM\Column(name="available", type="boolean")
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/availability",
     *              "@type"="@id"
     *          },
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
     *
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/price",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "float",
     *              "example": "195.99"
     *          }
     *     }
     * )
     */
    private $price;

    /**
     * Physical condition
     *
     * @var string
     * @see AppBundle\Entity\Enumerations\PhysicState
     *
     * @ORM\Column(name="physic_state", type="string", length=15)
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/itemCondition",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "string",
     *              "enum"= {"Jamais utilisé", "Comme neuf", "Bon", "Moyen", "Mauvais"},
     *              "example"= "Mauvais"
     *          }
     *     }
     * )
     */
    private $physicState;

    /**
     * Sell state of product
     *
     * @var string
     * @see AppBundle\Entity\Enumerations\SellState
     *
     * @ORM\Column(name="sell_state", type="string", length=15)
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/itemCondition",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "string",
     *              "name" = "sell_state",
     *              "enum"= {"Neuf", "Reconditionné", "Occasion", "Défectueux"},
     *              "example"= "Défectueux"
     *          }
     *     }
     * )
     */
    private $sellState;

    /**
     * Text about phone historic
     *
     * @var string|null
     *
     * @ORM\Column(name="history", type="text", nullable=true)
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/disambiguatingDescription",
     *              "@type"="@id"
     *          },
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
     *
     * @var string
     *
     * @ORM\Column(name="imei", type="string")
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/serialNumber",
     *              "@type"="@id"
     *          },
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
     *
     * @var int
     *
     * @ORM\Column(name="memory_size_in_gb", type="integer")
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/additionalType",
     *              "@type"="@id"
     *          },
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
     *
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=55)
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/additionalType",
     *              "@type"="@id"
     *          },
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
     *
     * @var bool
     *
     * @ORM\Column(name="operator_lock", type="boolean")
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/additionalType",
     *              "@type"="@id"
     *          },
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
     *
     * @var string
     *
     * @ORM\Column(name="system_version", type="string", length=55)
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/additionalType",
     *              "@type"="@id"
     *          },
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
     *
     * @var bool
     *
     * @ORM\Column(name="formatted", type="string")
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/additionalType",
     *              "@type"="@id"
     *          },
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
     *
     * @var string
     * @see AppBundle\Entity\Enumerations\ProductState
     *
     * @ORM\Column(name="soft_status", type="string")
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/additionalType",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "string",
     *              "enum" = {"Démarre normalement", "Problème soft", "Brick logiciel - Ne démarre pas", "Non testé / Inconnu"},
     *              "example": "Inconnu"
     *          }
     *     }
     * )
     */
    private $softStatus;

    /**
     * Product model
     *
     * @var Model
     *
     * @ORM\ManyToOne(
     *     targetEntity="Model",
     *     inversedBy="products"
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/Product",
     *              "@type"="Product\Model"
     *          }
     *     }
     * )
     */
    private $model;

    /**
     * Notices linked to Product
     *
     * @var mixed
     *
     * @ORM\OneToMany(
     *     targetEntity="Notice",
     *     mappedBy="product",
     *     cascade={"persist"}
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/Thing",
     *              "@type"="Product\Notice"
     *          },
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
     *
     * @var mixed
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Guarantee\ProductSpecific",
     *     mappedBy="product"
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/warranty",
     *              "@type"="Guarantee\ProductSpecific"
     *          },
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
     *
     * @var ProductGlobal|null
     *
     * @ORM\OneToOne(
     *  targetEntity="\AppBundle\Entity\Guarantee\ProductGlobal"
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/warranty",
     *              "@type"="Guarantee\ProductGlobal"
     *          },
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
     * Get URL to item
     *
     * @return string
     */
    private function getSelfLink() : string
    {
        return "/products/" . $this->getId();
    }


    // Product normalization

    /**
     * Product normalization for collection request
     *
     * @param bool $links -Normalize with _links
     * @param bool $brand -Normalize with _embedded[brand]
     * @param bool $family -Normalize with _embedded[brand]
     * @param bool $model -Normalize with _embedded[brand]
     *
     * @return array
     */
    public function normalizeProductCollection($links = true, $brand=true, $family=true, $model = true) : array
    {
        $return = [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'sell_state' => $this->getSellState(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'available' => $this->getAvailable()
        ];

        if ($links) {
            $return['_links'] = $this->normalizeProductLinks();
        }


        if ($brand || $family || $model) {
            $return['embedded'] = $this->normalizeProductEmbedded($brand, $family, $model);
        }

        return $return;
    }

    /**
     * Product normalization for item request
     *
     * @param bool $links -Normalize with _links
     * @param bool $brand -Normalize with _embedded[brand]
     * @param bool $family -Normalize with _embedded[brand]
     * @param bool $model -Normalize with _embedded[brand]
     *
     * @return array
     */
    public function normalizeProductItem($links = true, $brand=true, $family=true, $model = true) : array
    {

        // Fill return array with Product properties
        $return = [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'sell_state' => $this->getSellState(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'available' => $this->getAvailable(),
            'physic_state' => $this->getPhysicState(),
            'soft_status' => $this->getSoftStatus(),
            'is_formatted' => $this->getFormatted(),
            'history' => $this->getHistory(),
            'imei' => $this->getImei(),
            'color' => $this->getColor(),
            'memory_size' => $this->getMemorySizeInGb(),
            'system_version' => $this->getSystemVersion()
        ];

        // Check & store notices in $return if needed
        if ($this->shouldDisplayNotices()) {
            $return['notices'] = $this->normalizeProductNotices();
        }

        // Check & store GlobalGuarantee in $return if needed
        if ($this->shouldDisplayGlobalGuarantee()) {
            $return['global_guarantee'] = $this->normalizeProductGlobalGuarantee();
        }

        // Check & store SpecificGuarantees in $return if needed
        if ($this->shouldDisplaySpecificGuarantees()) {
            $return['specific_guarantees'] = $this->normalizeProductSpecificGuarantees();
        }

        if ($links) {
            $return['_links'] = $this->normalizeProductLinks();
        }

        if ($brand || $family || $model) {
            $return['_embedded'] = $this->normalizeProductEmbedded($brand, $family, $model);
        }

        return $return;
    }

    /**
     * Normalize _links
     *
     * @return array
     */
    public function normalizeProductLinks()
    {
        return [
            '@self' => $this->getSelfLink(),
        ];
    }

    /**
     * Normalize _embedded
     *
     * @param bool $brand -Normalize with _embedded[brand]
     * @param bool $family -Normalize with _embedded[brand]
     * @param bool $model -Normalize with _embedded[brand]
     *
     * @return array
     */
    public function normalizeProductEmbedded($brand, $family, $model)
    {
        $return = [];

        if ($brand) {
            $return['brand'] = $this->getModel()->getFamily()->getBrand()->normalizeBrandCollection(true);
        }
        if ($family) {
            $return['family'] = $this->getModel()->getFamily()->normalizeFamilyCollection(true, false);
        }
        if ($model) {
            $return['model'] = $this->getModel()->normalizeModelCollection(true, false, false);
        }

        return $return;
    }


    /**
     * Product SubResources normalization
     */

    // Notices

    /**
     * Return true if product has notices
     *
     * @return bool
     */
    public function shouldDisplayNotices() : bool
    {
        return $this->getNotices()->count() !== 0;
    }

    /**
     * Normalize Notices
     *
     * @return array
     */
    private function normalizeProductNotices() : array
    {
        // Fetch and loop on every notices
        foreach ($this->getNotices() as $v) {
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
     *
     * @return bool
     */
    public function shouldDisplayGlobalGuarantee() : bool
    {
        return $this->getGlobalGuarantee() !== null;
    }

    /**
     * Normalize GlobalGuarantee
     *
     * @return array
     */
    public function normalizeProductGlobalGuarantee() : array
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
     *
     * @return bool
     */
    public function shouldDisplaySpecificGuarantees() : bool
    {
        return $this->getSpecificGuarantees()->count() !== 0;
    }

    /**
     * Normalize specifics guarantees
     *
     * @return array
     */
    public function normalizeProductSpecificGuarantees() : array
    {

        // Get product guarantee(s)
        $guars = $this->getSpecificGuarantees();
        // Init empty array
        $return = [];

        // Loop on every guarantee
        foreach ($guars as $guar) {
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
     * @return int|null
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
    public function setTitle(string $title) : Product
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle() : string
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
    public function setDescription(string $description) : Product
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
     * Set available.
     *
     * @param bool $available
     *
     * @return Product
     */
    public function setAvailable(bool $available) : Product
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available.
     *
     * @return bool
     */
    public function getAvailable() : bool
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
    public function setPrice(float $price) : Product
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice() : float
    {
        return $this->price;
    }

    /**
     * Set physicState.
     *
     * @param String $physicState
     *
     * @return Product
     */
    public function setPhysicState(String $physicState) : Product
    {
        if (!in_array($physicState, PhysicState::getAvailableTypes())) {
            throw new \InvalidArgumentException("Invalid ProductPhysicState");
        }

        $this->physicState = $physicState;

        return $this;
    }

    /**
     * Get physicState.
     *
     * @return string
     */
    public function getPhysicState() : string
    {
        return PhysicState::getValue($this->physicState);
    }

    /**
     * Set sellState.
     *
     * @param String $sellState
     *
     * @return Product
     */
    public function setSellState(String $sellState) : Product
    {
        if (!in_array($sellState, SellState::getAvailableTypes())) {
            throw new \InvalidArgumentException("Invalid ProductState");
        }

        $this->sellState = $sellState;

        return $this;
    }

    /**
     * Get sellState.
     *
     * @return String
     */
    public function getSellState() : string
    {
        return SellState::getValue($this->sellState);
    }

    /**
     * Set history.
     *
     * @param string|null $history
     *
     * @return Product
     */
    public function setHistory($history = null) : Product
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
     * @param string $imei
     *
     * @return Product
     */
    public function setImei(string $imei) : Product
    {
        $this->imei = $imei;

        return $this;
    }

    /**
     * Get imei.
     *
     * @return string
     */
    public function getImei() : string
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
    public function setMemorySizeInGb(int $memorySizeInGb) : Product
    {
        $this->memorySizeInGb = $memorySizeInGb;

        return $this;
    }

    /**
     * Get memorySizeInGb.
     *
     * @return int
     */
    public function getMemorySizeInGb() : int
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
    public function setColor(string $color) : Product
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color.
     *
     * @return string
     */
    public function getColor() : string
    {
        return $this->color;
    }

    /**
     * Is the product operator-locked
     *
     * @return bool
     */
    public function getOperatorLock() : bool
    {
        return $this->operatorLock;
    }

    /**
     * Set operatorLock
     *
     * @param bool $locked
     *
     * @return Product
     */
    public function setOperatorLock(bool $locked) : Product
    {
        $this->operatorLock = $locked;

        return $this;
    }

    /**
     * Set systemVersion.
     *
     * @param string $systemVersion
     *
     * @return Product
     */
    public function setSystemVersion(string $systemVersion) : Product
    {
        $this->systemVersion = $systemVersion;

        return $this;
    }

    /**
     * Get systemVersion.
     *
     * @return string
     */
    public function getSystemVersion() : string
    {
        return $this->systemVersion;
    }

    /**
     * Set formatted.
     *
     * @param string $formatted
     * @see ProductFormatStatus
     *
     * @throw \InvalidArgumentException
     * @return Product
     */
    public function setFormatted(string $formatted) : Product
    {
        if (!in_array($formatted, ProductFormatStatus::getAvailableTypes())) {
            throw new \InvalidArgumentException("Invalid ProductFormatStatus");
        }

        $this->formatted = $formatted;

        return $this;
    }

    /**
     * Get format status.
     *
     * @return string
     */
    public function getFormatted() : string
    {
        return ProductFormatStatus::getValue($this->formatted);
    }

    /**
     * Set softStatus.
     *
     * @param string $bootStatus
     * @see ProductSoftStatus
     *
     * @throw \InvalidArgumentException
     * @return Product
     */
    public function setSoftStatus(string $bootStatus) : Product
    {
        if (!in_array($bootStatus, ProductSoftStatus::getAvailableTypes())) {
            throw new \InvalidArgumentException("Invalid ProductSoftStatus");
        }

        $this->softStatus = $bootStatus;

        return $this;
    }

    /**
     * Get softStatus.
     *
     * @return string
     */
    public function getSoftStatus() : string
    {
        return ProductSoftStatus::getValue($this->softStatus);
    }

    /**
     * Get model
     *
     * @return model
     */
    public function getModel() : Model
    {
        return $this->model;
    }

    /**
     * Set model
     *
     * @param Model $model
     *
     * @return Product
     */
    public function setModel(Model $model) : Product
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get notices
     *
     * @return mixed
     */
    public function getNotices()
    {
        return $this->notices;
    }

    /**
     * Get specificGuarantees
     *
     * @return mixed
     */
    public function getSpecificGuarantees()
    {
        return $this->specificGuarantees;
    }

    /**
     * Set globalGuarantee
     *
     * @param $guarantee ProductGlobal
     *
     * @return Product
     */
    public function setGlobalGuarantee(ProductGlobal $guarantee) : Product
    {
        $this->globalGuarantee = $guarantee;

        return $this;
    }

    /**
     * Get globalGuarantee
     *
     * @return ProductGlobal|null
     */
    public function getGlobalGuarantee()
    {
        return $this->globalGuarantee;
    }
}
