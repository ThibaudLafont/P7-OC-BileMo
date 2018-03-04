<?php

namespace AppBundle\Entity\Product;

use AppBundle\Entity\Enumerations\NoticeType;
use Doctrine\ORM\Mapping as ORM;

/**
 * Notice
 *
 * @ORM\Table(name="p_notice")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\NoticeRepository")
 */
class Notice
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
     * Type of notice,
     * Handle by Enumeration\NoticeType
     *
     * @ORM\Column(name="type", type="string", length=15)
     */
    private $type;

    /**
     * @var string
     * Message to display
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(
     *     targetEntity="Product",
     *     inversedBy="notices")
     */
    private $product;

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
     * Set type.
     *
     * @param int $type
     *
     * @return Notice
     */
    public function setType($type)
    {
        if (!in_array($type, NoticeType::getAvailableTypes())) {
            throw new \InvalidArgumentException("Invalid NoticeType");
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return int
     */
    public function getType()
    {
        return NoticeType::getValue($this->type);
    }

    /**
     * Set message.
     *
     * @param string $message
     *
     * @return Notice
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
     * Get product
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set product
     *
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

}
