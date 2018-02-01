<?php

namespace AppBundle\Entity\Feature;

use AppBundle\Entity\Product\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * ProductTest
 *
 * @ORM\Table(name="feature_product_test")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Feature\ProductTestRepository")
 */
class ProductTest
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
     * @var bool
     *
     * @ORM\Column(name="phy_damager", type="boolean")
     */
    private $phyDamage;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_working", type="boolean")
     */
    private $isWorking;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Feature",
     *     inversedBy="tests"
     * )
     */
    private $feature;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Product\Product",
     *     inversedBy="tests"
     * )
     */
    private $product;

    public function getFeature()
    {
        return $this->feature;
    }
    public function setFeature(Feature $feature)
    {
        $this->feature = $feature;
    }
    public function getProduct()
    {
        return $this->product;
    }
    public function setProduct(Product $product)
    {
        $this->product = $product;
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
     * Set feature has physical damages
     *
     * @param bool $phyDamage
     *
     * @return ProductTest
     */
    public function setPhyDamage(bool $phyDamage)
    {
        $this->phyDamage = $phyDamage;

        return $this;
    }

    /**
     * Get does feature has phy damages
     *
     * @return int
     */
    public function getPhyDamage()
    {
        return $this->phyDamage;
    }

    /**
     * Set isWorking
     *
     * @param bool $isWorking
     *
     * @return ProductTest
     */
    public function setIsWorking(bool $isWorking)
    {
        $this->isWorking = $isWorking;

        return $this;
    }

    /**
     * Get isWorking
     *
     * @return int
     */
    public function getIsWorking()
    {
        return $this->isWorking;
    }

    /**
     * Set message.
     *
     * @param string $message
     *
     * @return ProductTest
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
