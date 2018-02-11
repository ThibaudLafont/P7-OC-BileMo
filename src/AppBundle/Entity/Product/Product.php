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

/**
 * Product
 *
 * @ApiResource(
 *     collectionOperations={
 *          "product_list"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"product_list"}
 *              }
 *          }
 *     },
 *     itemOperations={
 *          "product_show"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"product_show"}
 *              }
 *          }
 *     }
 * )
 *
 * @ORM\Table(name="p_product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * Doctrine
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Main title of product
     * @var string
     *
     * Doctrine
     * @ORM\Column(name="title", type="string", length=55)
     */
    private $title;

    /**
     * Main description of product
     * @var string
     *
     * Doctrine
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * Is the product still available
     * @var bool
     *
     * Doctrine
     * @ORM\Column(name="available", type="boolean")
     */
    private $available;

    /**
     * Price of product
     * @var float
     *
     * Doctrine
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * Physical condition, linked to Enumerations\ProductCondition
     * @var string
     *
     * Doctrine
     * @ORM\Column(name="phy_condition", type="string", length=15)
     */
    private $condition;

    /**
     * Sell state, liked to Enumerations\ProductState
     * @var string
     *
     * Doctrine
     * @ORM\Column(name="state", type="string", length=15)
     */
    private $state;

    /**
     * Text about phone historic
     * @var string|null
     *
     * Doctrine
     * @ORM\Column(name="history", type="text", nullable=true)
     */
    private $history;

    /**
     * IMEI number
     * @var int
     *
     * Doctrine
     * @ORM\Column(name="imei", type="bigint")
     */
    private $imei;

    /**
     * Memory Size in GigaBytes
     * @var int
     *
     * Doctrine
     * @ORM\Column(name="memorySizeInGb", type="integer")
     */
    private $memorySizeInGb;

    /**
     * Color of product
     * @var string
     *
     * Doctrine
     * @ORM\Column(name="color", type="string", length=55)
     */
    private $color;

    /**
     * Is locked by operator
     * @var bool
     *
     * Doctrine
     * @ORM\Column(name="operator_lock", type="boolean")
     */
    private $operatorLock;

    /**
     * System version
     * @var string
     *
     * Doctrine
     * @ORM\Column(name="system_version", type="string", length=55)
     */
    private $systemVersion;

    /**
     * Has been formatted
     * @var bool
     *
     * Doctrine
     * @ORM\Column(name="formatted", type="string")
     */
    private $formatted;

    /**
     * Does product boot properly
     * @var bool
     *
     * Doctrine
     * @ORM\Column(name="boot_properly", type="string")
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
     */
    private $notices;

    /**
     * Features test
     * @var \AppBundle\Entity\Feature\Test
     *
     * Doctrine
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Feature\Test",
     *     mappedBy="product"
     * )
     */
    private $tests;

    /**
     * Guarantee linked to specific product feature
     * @var \AppBundle\Entity\Feature\ProductTest
     *
     * Doctrine
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Guarantee\ProductSpecific",
     *     mappedBy="product"
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
     */
    private $globalGuarantee;

    // Traits
    use Hydrate;

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
     * @param string $title
     *
     * @return Product
     */
    public function setName($title)
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
     * Get tests
     *
     * @return \AppBundle\Entity\Feature\Test
     */
    public function getTests()
    {
        return $this->tests;
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
