<?php

namespace AppBundle\Entity\Product;

use AppBundle\Entity\Enumerations\NoticeType;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

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
     *
     * @ORM\Column(name="type", type="string", length=15)
     * @Groups("product_show")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Groups("product_show")
     */
    private $content;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(
     *     targetEntity="Product",
     *     inversedBy="notices")
     */
    private $product;

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
     * Set content.
     *
     * @param string $content
     *
     * @return Notice
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}
