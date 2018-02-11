<?php
namespace AppBundle\Entity\Feature;

use AppBundle\Entity\Product\Product;
use AppBundle\Entity\Traits\Hydrate;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Test
 *
 * @ORM\Table(name="fp_test")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Feature\ProductTestRepository")
 */
class Test
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
     * Is physically damaged
     *
     * @ORM\Column(name="phy_damager", type="boolean")
     * @Groups({"product_show"})
     */
    private $phyDamage;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_working", type="boolean")
     * @Groups({"product_show"})
     */
    private $isWorking;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     * @Groups({"product_show"})
     */
    private $message;

    /**
     * @var Feature
     *
     * @ORM\ManyToOne(
     *     targetEntity="Feature",
     *     inversedBy="tests"
     * )
     * @Groups({"product_show"})
     */
    private $feature;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Product\Product",
     *     inversedBy="tests"
     * )
     */
    private $product;

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

    /**
     * Get feature
     *
     * @return Feature
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * Set Feature
     *
     * @param Feature $feature
     */
    public function setFeature(Feature $feature)
    {
        $this->feature = $feature;
    }

    /**
     * Get Product
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set Product
     *
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

}
