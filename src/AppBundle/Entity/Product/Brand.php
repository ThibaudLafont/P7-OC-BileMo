<?php

namespace AppBundle\Entity\Product;

use AppBundle\Entity\Traits\Hydrate;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Brand
 *
 * @ApiResource(
 *     collectionOperations={
 *          "brand_list"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"brand_list"}
 *              }
 *          }
 *     },
 *     itemOperations={
 *          "brand_show"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"brand_show"}
 *              }
 *          }
 *     }
 * )
 *
 * @ORM\Table(name="p_brand")
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
     *
     * @Groups({"brand_list", "brand_show"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=55, unique=true)
     * @Groups({"brand_list", "brand_show"})
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Groups({"brand_show"})
     */
    private $description;

    /**
     * @var string|null
     * Brand home page
     *
     * @ORM\Column(name="website_url", type="string", length=255, nullable=true)
     * @Groups({"brand_show"})
     */
    private $websiteUrl;

    /**
     * @var array
     * Brand's families
     *
     * @ORM\OneToMany(
     *     targetEntity="Family",
     *     mappedBy="brand"
     * )
     *
     * @ApiSubresource
     * @Groups({"brand_show"})
     */
    private $families;

    /**
     * @var array
     * Brand's models
     *
     * @ORM\OneToMany(
     *     targetEntity="Model",
     *     mappedBy="brand"
     * )
     *
     * @ApiSubresource
     */
    private $models;

    // Traits
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

    /**
     * Get families
     *
     * @return array
     */
    public function getFamilies()
    {
        return $this->families;
    }

    /**
     * Get models
     *
     * @return array
     */
    public function getModels()
    {
        return $this->models;
    }

}
