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
     * @ORM\Column(name="phy_condition", type="integer")
     */
    private $condition;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state;

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
     * @var bool
     *
     * @ORM\Column(name="operator_lock", type="boolean")
     */
    private $operatorLock;

    /**
     * @var string
     *
     * @ORM\Column(name="system_version", type="string", length=55)
     */
    private $systemVersion;

    /**
     * @var bool
     *
     * @ORM\Column(name="formatted", type="boolean", nullable=true)
     */
    private $formatted;

    /**
     * @var bool
     *
     * @ORM\Column(name="boot_properly", type="boolean", nullable=true)
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
     * @var Model
     *
     * @ORM\ManyToOne(
     *     targetEntity="Model",
     *     inversedBy="products"
     * )
     */
    private $model;

    /**
     * @var Notice
     *
     * @ORM\OneToMany(
     *     targetEntity="Notice",
     *     mappedBy="product",
     *     cascade={"persist"}
     * )
     */
    private $notices;

    /**
     * @var \AppBundle\Entity\Feature\ProductTest
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Feature\ProductTest",
     *     mappedBy="product"
     * )
     */
    private $tests;

    /**
     * @var \AppBundle\Entity\Feature\ProductTest
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Guarantee\ProductSpecific",
     *     mappedBy="product"
     * )
     */
    private $specificGuarantees;

    /**
     * @ORM\OneToOne(
     *  targetEntity="\AppBundle\Entity\Guarantee\ProductGlobal"
     * )
     */
    private $globalGuarantee;

    // Condition constants
    const NEW = 1;
    const REFURB = 2;
    const USED = 3;
    const DEFECTIVE = 3;

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

    public function getModel()
    {
        return $this->model;
    }
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    public function getNotices()
    {
        return $this->notices;
    }

    public function getTests()
    {
        return $this->tests;
    }
    public function getSpecificGuarantees()
    {
        return $this->specificGuarantees;
    }

    public function setGlobalGuarantee($guarantee)
    {
        if(
            get_class($guarantee, '\AppBundle\Guarantee\ProductGlobal') ||
            is_null($guarantee)
        ) $this->globalGuarantee = $guarantee;
    }
    public function getGlobalGuarantee()
    {
        return $this->globalGuarantee;
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
     * Set condition.
     *
     * @return Product
     */
    public function setCondition($condition)
    {
        if($condition === 'new') $condition = self::NEW;
        elseif($condition === 'refurb') $condition = self::REFURB;
        elseif($condition === 'used') $condition = self::USED;
        elseif($condition === 'defective') $condition = self::DEFECTIVE;
        elseif(
            !in_array(
                $condition,
                [self::DEFECTIVE, self::USED, self::REFURB, self::NEW]
            )
        ) return false;

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
        $condition = $this->condition;

        if($condition === self::NEW) $condition = 'Neuf';
        elseif($condition === self::REFURB) $condition = 'Reconditionné';
        elseif($condition === self::USED) $condition = 'Occasion';
        elseif($condition === self::DEFECTIVE) $condition = 'Défectueux';

        return $condition;
    }

    /**
     * Set state.
     *
     * @param int $state
     *
     * @return Product
     */
    public function setState($state)
    {

        if($state === 'unused') $state = self::UNUSED;
        elseif($state === 'like_new') $state = self::LIKE_NEW;
        elseif($state === 'good') $state = self::GOOD;
        elseif($state === 'average') $state = self::AVERAGE;
        elseif($state === 'bad') $state = self::BAD;
        elseif(
            !in_array(
                $state,
                [self::BAD, self::AVERAGE, self::GOOD, self::LIKE_NEW, self::UNUSED]
            )
        ) return false;

        $this->state = $state;

        return $this;
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        $state = $this->state;
        if($state === self::UNUSED) $state = 'Non utilisé';
        elseif($state === self::LIKE_NEW) $state = 'Comme neuf';
        elseif($state === self::GOOD) $state = 'Bon';
        elseif($state === self::AVERAGE) $state = 'Moyen';
        elseif($state === self::BAD) $state = 'Mauvais';

        return $state;
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
    public function setBootProperly($bootProperly)
    {
        $this->bootProperly = $bootProperly;

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
