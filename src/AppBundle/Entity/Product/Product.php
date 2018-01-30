<?php

namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product_product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\ProductRepository")
 */
class Product
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
     * @var bool
     *
     * @ORM\Column(name="available", type="boolean")
     */
    private $available;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="work_condition", type="integer")
     */
    private $workCondition;

    /**
     * @var int
     *
     * @ORM\Column(name="sell_state", type="integer")
     */
    private $sellState;

    /**
     * @var string|null
     *
     * @ORM\Column(name="history", type="text", nullable=true)
     */
    private $history;

    /**
     * @var int
     *
     * @ORM\Column(name="imei", type="bigint")
     */
    private $imei;

    /**
     * @var int
     *
     * @ORM\Column(name="memorySizeInGb", type="integer")
     */
    private $memorySizeInGb;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=55)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="system_version", type="string", length=55)
     */
    private $systemVersion;

    /**
     * @var bool
     *
     * @ORM\Column(name="formatted", type="boolean")
     */
    private $formatted;

    /**
     * @var bool
     *
     * @ORM\Column(name="boot_properly", type="boolean")
     */
    private $bootProperly;

    /**
     * @var \AppBundle\Entity\Media\Product\Local\Product
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Media\Product\Local\Product",
     *     mappedBy="product"
     * )
     */
    private $localMedias;

    /**
     * @var \AppBundle\Entity\Media\Product\Distant\Product
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Media\Product\Distant\Product",
     *     mappedBy="product"
     * )
     */
    private $distantMedias;

    /**
     * @var AppBundle\Entity\Feature\ProductTest
     *
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Feature\ProductTest",
     *     inversedBy="products")
     */
    private $test;

    /**
     * @var Model
     *
     * @ORM\ManyToOne(
     *     targetEntity="Model",
     *     inversedBy="products"
     * )
     */
    private $model;

    /**
     * @var AppBundle\Entity\Guarantee\ProductGlobal
     *
     * @ORM\OneToOne(
     *     targetEntity="AppBundle\Entity\Guarantee\ProductGlobal"
     * )
     */
    private $globalGuarantee;

    /**
     * @var Notice
     *
     * @ORM\OneToMany(
     *     targetEntity="Notice",
     *     mappedBy="product"
     * )
     */
    private $notices;

    // Condition constants
    const NEW = 1;
    const REFURBISH = 2;
    const USED = 3;

    // State constants
    const UNUSED = 4;
    const LIKE_NEW = 5;
    const GOOD = 6;
    const AVERAGE = 7;
    const BAD = 8;

    public function getLocalMedias()
    {
        return $this->localMedias;
    }
    public function getDistantMedias()
    {
        return $this->distantMedias;
    }

    public function getTest()
    {
        return $this->test;
    }
    public function setTest(ProductTest $test)
    {
        $this->test = $test;
    }

    public function getModel()
    {
        return $this->model;
    }
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    public function getGlobalGuarantee()
    {
        return $this->globalGuarantee;
    }
    public function setGlobalGuarantee(ProductGlobal $guarantee)
    {
        $this->globalGuarantee = $guarantee;
    }

    public function getNotices()
    {
        return $this->notices;
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
     * @return Product
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
     * Set workCondition.
     *
     * @param int $workCondition
     *
     * @return Product
     */
    public function setWorkCondition($workCondition)
    {
        $this->workCondition = $workCondition;

        return $this;
    }

    /**
     * Get workCondition.
     *
     * @return int
     */
    public function getWorkCondition()
    {
        return $this->workCondition;
    }

    /**
     * Set sellState.
     *
     * @param int $sellState
     *
     * @return Product
     */
    public function setSellState($sellState)
    {
        $this->sellState = $sellState;

        return $this;
    }

    /**
     * Get sellState.
     *
     * @return int
     */
    public function getSellState()
    {
        return $this->sellState;
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
     * @param bool $formatted
     *
     * @return Product
     */
    public function setFormatted($formatted)
    {
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
        return $this->formatted;
    }

    /**
     * Set bootProperly.
     *
     * @param bool $bootProperly
     *
     * @return Product
     */
    public function setBootProperly($bootPropely)
    {
        $this->bootProperly = $bootPropely;

        return $this;
    }

    /**
     * Get bootProperly.
     *
     * @return bool
     */
    public function getBootProperly()
    {
        return $this->bootProperly;
    }
}
