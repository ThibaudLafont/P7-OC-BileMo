<?php
namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Partner
 *
 * @package AppBundle\Entity\User
 *
 * @ORM\Table(name="user_partner")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\PartnerRepository")
 */
class Partner extends User
{

    // ApiProperties methods

    /**
     * Primary key of resource
     *
     * @return int
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "integer",
     *              "example" = "1"
     *          }
     *     }
     * )
     */
    public function getId() : int
    {
        return parent::getId();
    }

    /**
     * Username of User
     *
     * @return string
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example" = "johndoe"
     *          }
     *     }
     * )
     */
    public function getUsername() : string
    {
        return parent::getUsername();
    }


    // Normalization methods

    /**
     * Normalize Partner
     *
     * @return array
     */
    public function normalizePartnerCollection() : array
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            '_links' => [
                '@self' => $this->getSelfUrl()
            ]
        ];
    }

    /**
     * Get URL to item
     *
     * @return string
     */
    private function getSelfUrl() : string
    {
        return "/partners/" . $this->getId();
    }


    // Authorization

    /**
     * Returns the roles granted to the user.
     *
     * @return array
     */
    public function getRoles() : array
    {
        return ['ROLE_ADMIN'];
    }

}
