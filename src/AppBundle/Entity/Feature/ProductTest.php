<?php

namespace AppBundle\Entity\Feature;

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
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Product\Product",
     *     mappedBy="test"
     * )
     */
    private $products;

    public function getProducts()
    {
        return $this->products;
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
     * Set status.
     *
     * @param int $status
     *
     * @return ProductTest
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
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
