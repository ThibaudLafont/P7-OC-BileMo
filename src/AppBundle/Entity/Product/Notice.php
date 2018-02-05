<?php

namespace AppBundle\Entity\Product;

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
     * @ORM\Column(name="type", type="integer")
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

    // Constants
    const INFO = 1;
    const ALERT = 2;

    public function getProductNotice(){
        return [
            'type' => $this->getType(),
            'message' => $this->getContent()
        ];
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
     * Set type.
     *
     * @param int $type
     *
     * @return Notice
     */
    public function setType($type)
    {
        if($type === 'info') $type = self::INFO;
        elseif($type === 'alert') $type = self::ALERT;
        elseif(
            !in_array($type, [self::INFO, self::ALERT])
        ) return false;

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
        $type = $this->type;

        if($type === self::INFO) $type = 'Information';
        elseif($type === self::INFO) $type = 'Alerte';

        return $type;
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
