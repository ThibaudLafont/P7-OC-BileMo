<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * Partner
 *
 * @ORM\Table(name="user_partner")
 * @ORM\Entity
 */
class Partner extends User
{

    // ApiProperties methods

    /**
     * @return int
     * Primary key of resource
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
    public function getId()
    {
        return parent::getId();
    }

    /**
     * @return string
     * Username of User
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
    public function getUsername()
    {
        return parent::getUsername();
    }


    // Normalization methods

    /**
     * @return array
     */
    public function getPartnerCollection(){
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            '_links' => [
                '@self' => $this->getSelfUrl()
            ]
        ];
    }

    public function getSelfUrl(){
        return "/partners/" . $this->getId();
    }


    // Authorization

    /**
     * Returns the roles granted to the user.
     */
    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }

}
