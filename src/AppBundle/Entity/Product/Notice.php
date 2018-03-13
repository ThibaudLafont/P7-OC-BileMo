<?php
namespace AppBundle\Entity\Product;

use AppBundle\Entity\Traits\Hydrate;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Enumerations\NoticeType;

/**
 * Notice
 *
 * @package AppBundle\Entity\Product
 *
 * @ORM\Table(name="p_notice")
 * @ORM\Entity()
 */
class Notice
{

    /**
     * Primary key of resource
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Type of notice,
     * Handle by Enumeration\NoticeType
     *
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=15)
     */
    private $type;

    /**
     * Message to display
     *
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * Concerned Product
     *
     * @var Product
     *
     * @ORM\ManyToOne(
     *     targetEntity="Product",
     *     inversedBy="notices")
     */
    private $product;

    // Traits
    use Hydrate;


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
     * Set type
     *
     * @param string $type
     *
     * @throws \InvalidArgumentException
     * @return Notice
     */
    public function setType(string $type) : Notice
    {
        // if unknow type, throw execption
        if (!in_array($type, NoticeType::getAvailableTypes())) {
            throw new \InvalidArgumentException("Invalid NoticeType");
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType() : string
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
    public function setMessage(string $message) : Notice
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * Get product
     *
     * @return Product
     */
    public function getProduct() : Product
    {
        return $this->product;
    }

    /**
     * Set product
     *
     * @param Product $product
     *
     * @return Notice
     */
    public function setProduct(Product $product) : Notice
    {
        $this->product = $product;

        return $this;
    }
}
