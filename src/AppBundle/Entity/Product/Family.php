<?php

namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Family
 *
 * @ApiResource(
 *     collectionOperations={
 *          "family_list"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"family_list"}
 *              }
 *          }
 *     },
 *     itemOperations={
 *          "family_show"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"family_show"}
 *              }
 *          }
 *     },
 *     subresourceOperations={
 *          "api_brands_families_get_subresource"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"brand_subresource"}
 *              }
 *          }
 *     }
 * )
 *
 * @ORM\Table(name="p_family")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\FamilyRepository")
 */
class Family
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"brand_show"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=55)
     *
     * @Groups({"brand_show"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var Brand
     * Family's brand
     *
     * @ORM\ManyToOne(
     *     targetEntity="Brand",
     *     inversedBy="families"
     * )
     */
    private $brand;

    /**
     * @var Model
     * Family's models
     *
     * @ORM\OneToMany(
     *     targetEntity="Model",
     *     mappedBy="family"
     * )
     * @Groups({"brand_show"})
     */
    private $models;

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
     * @return Family
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
     * @return Family
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
     * Get brand
     *
     * @return Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set brand
     *
     * @param Brand $brand
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Get models
     *
     * @return Model
     */
    public function getModels()
    {
        return $this->models;
    }

}
