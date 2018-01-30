<?php

namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * Brand
 *
 * @ORM\Table(name="product_brand")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\BrandRepository")
 */
class Brand
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
     * @ORM\Column(name="name", type="string", length=55, unique=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="website_url", type="string", length=255, nullable=true)
     */
    private $websiteUrl;

    /**
     * @var \AppBundle\Entity\Media\Product\Distant\Brand
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Media\Product\Distant\Brand",
     *     mappedBy="brand"
     * )
     */
    private $distantMedias;

    /**
     * @var \AppBundle\Entity\Media\Product\Local\Brand
     *
     * @ORM\OneToMany(
     *     targetEntity="\AppBundle\Entity\Media\Product\Local\Brand",
     *     mappedBy="brand"
     * )
     */
    private $localMedias;

    /**
     * @var Family
     *
     * @ORM\OneToMany(
     *     targetEntity="Family",
     *     mappedBy="brand"
     * )
     */
    private $families;

    /**
     * @var Model
     *
     * @ORM\OneToMany(
     *     targetEntity="Model",
     *     mappedBy="brand"
     * )
     */
    private $models;

    public function getLocalMedias()
    {
        return $this->localMedias;
    }
    public function getDistantMedias()
    {
        return $this->distantMedias;
    }

    public function getFamilies()
    {
        return $this->families;
    }
    public function getModels()
    {
        return $this->models;
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
     * @return Brand
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
     * @param string|null $description
     *
     * @return Brand
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set websiteUrl.
     *
     * @param string|null $websiteUrl
     *
     * @return Brand
     */
    public function setWebsiteUrl($websiteUrl = null)
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    /**
     * Get websiteUrl.
     *
     * @return string|null
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }
}
