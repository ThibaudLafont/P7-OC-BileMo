<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="user_client")
 * @ORM\Entity
 */
class Client extends User
{
    /**
     * @var int
     *
     * @ORM\Column(name="phone_number", type="bigint")
     */
    private $phoneNumber;

    /**
     * Set phoneNumber.
     *
     * @param int $phoneNumber
     *
     * @return Client
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber.
     *
     * @return int
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Returns the roles granted to the user.
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }
}
