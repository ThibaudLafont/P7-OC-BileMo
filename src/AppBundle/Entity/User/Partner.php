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
 * @ORM\Entity("AppBundle\Repository\User\UserRepository")
 */
class Partner extends User
{

    // ApiProperties methods

    /**
     * Primary key of resource
     *
     * @return int|null
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/identifier",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "integer",
     *              "example" = "1"
     *          }
     *     }
     * )
     */
    public function getId()
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
     *          "jsonld_context"={
     *              "@id"="http://schema.org/identifier",
     *              "@type"="@id"
     *          },
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
