<?php

namespace AppBundle\Entity\User;

use AppBundle\Entity\Traits\Hydrate;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Client
 * Represent an user of a bilemo's client company
 *
 * @ApiResource(
 *     collectionOperations={
 *          "client_list"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"client_list"}
 *              }
 *          }
 *     },
 *     itemOperations={
 *          "client_show"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"client_show"}
 *              }
 *          }
 *     },
 *     subresourceOperations={
 *          "api_companies_users_get_subresource"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"company_list"}
 *              }
 *          }
 *     }
 * )
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
     *
     * @Assert\NotBlank(
     *     message="Le prénom est obligatoire"
     * )
     * @Assert\Length(
     *     min=2,
     *     minMessage="Le prénom doit contenir plus de {{ limit }} caractères",
     *     max=70,
     *     maxMessage="Le prénom ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=155)
     *
     * @Assert\NotBlank(
     *     message="Le nom de famille est obligatoire"
     * )
     * @Assert\Length(
     *     min=2,
     *     minMessage="Le nom de famille doit contenir plus de {{ limit }} caractères",
     *     max=70,
     *     maxMessage="Le nom de famille ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_address", type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(
     *     message="L'adresse mail est obligatoire"
     * )
     * @Assert\Email(
     *     message="Veuillez entrer une adresse mail valide",
     *     checkMX=true,
     *     checkHost=true
     * )
     */
    private $mailAddress;

    /**
     * @var int
     *
     * @ORM\Column(name="phone_number", type="bigint")
     *
     * @Assert\NotBlank(
     *     message="Veuillez renseigner un numéro de téléphone"
     * )
     * @Assert\Length(
     *     min=10,
     *     max=10,
     *     exactMessage="Veuillez entrer le numéro au format français à 10 chiffres"
     * )
     */
    private $phoneNumber;

    /**
     * Company of this user
     * @var Company
     *
     * @ORM\ManyToOne(
     *     targetEntity="Company",
     *     inversedBy="users"
     * )
     */
    private $company;

    // Traits
    use Hydrate;

    public function getClientCollection(){
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'full_name' => $this->getFullName()
        ];
    }

    public function getClientItem(){
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'fist_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'mail_address' => $this->getMailAddress(),
            'phone_number' => $this->getPhoneNumber()
        ];
    }

    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getSelfUrl(){
        return "/clients/" . $this->getId();
    }

    public function getUserLinks(){
        return [
            '@self' => $this->getSelfUrl()
        ];
    }

    // Authorizations

    /**
     * Returns the roles granted to the user.
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }


    // GETTERS / SETTERS

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

    /**
     * Get company
     *
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set company
     *
     * @param Company $company
     */
    public function setCompany(Company $company){
        $this->company = $company;
    }

}
