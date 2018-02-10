<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="user_partner")
 * @ORM\Entity
 */
class Partner extends User
{

    /**
     * Returns the roles granted to the user.
     */
    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }

}
