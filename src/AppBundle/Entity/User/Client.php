<?php

namespace AppBundle\Entity\User;

use AppBundle\Entity\Traits\Hydrate;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Client
 *
 * @ApiResource
 *
 * @ORM\Table(name="user_client")
 * @ORM\Entity
 */
class Client extends User
{

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=70)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=155)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_address", type="string", length=255, unique=true)
     */
    private $mailAddress;

    /**
     * @var int
     *
     * @ORM\Column(name="phone_number", type="bigint")
     */
    private $phoneNumber;

    /**
     * Company of user
     *
     * @ORM\ManyToOne(
     *     targetEntity="Company",
     *     inversedBy="users"
     * )
     */
    private $company;

    use Hydrate;

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set mailAddress.
     *
     * @param string $mailAddress
     *
     * @return User
     */
    public function setMailAddress($mailAddress)
    {
        $this->mailAddress = $mailAddress;

        return $this;
    }

    /**
     * Get mailAddress.
     *
     * @return string
     */
    public function getMailAddress()
    {
        return $this->mailAddress;
    }

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

    public function getCompany()
    {
        return $this->company;
    }
    public function setCompany(Company $company){
        $this->company = $company;
    }
    /**
     * Returns the roles granted to the user.
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }
}
