<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Partner
 *
 * @ORM\Table(name="user_partner")
 * @ORM\Entity
 *
 * @ApiResource(
 *     collectionOperations={
 *          "partner_list"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"partner_list"}
 *              }
 *          }
 *     },
 *     itemOperations={
 *          "partner_show"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"partner_show"}
 *              }
 *          }
 *     }
 * )
 */
class Partner extends User
{

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
