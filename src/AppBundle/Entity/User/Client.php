<?php

namespace AppBundle\Entity\User;

use AppBundle\Entity\Traits\Hydrate;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * Client
 * Represent an user of a bilemo's client company
 *
 * @ORM\Table(name="user_client")
 * @ORM\Entity
 *
 * @UniqueEntity(
 *     "username",
 *     message="Ce nom d'utilisateur n'est pas disponible"
 * )
 */
class Client extends User
{

    /**
     * @var string
     * First name of client
     *
     * @ORM\Column(name="firstName", type="string", length=70)
     *
     * @Assert\NotBlank(
     *     message="Le prénom est obligatoire",
     *     groups={"client_create"}
     * )
     * @Assert\Length(
     *     min=2,
     *     minMessage="Le prénom doit contenir plus de {{ limit }} caractères",
     *     max=70,
     *     maxMessage="Le prénom ne peut pas contenir plus de {{ limit }} caractères",
     *     groups={"client_create", "client_edit"}
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example" = "John"
     *          }
     *     }
     * )
     */
    private $firstName;

    /**
     * @var string
     * Last name of client
     *
     * @ORM\Column(name="lastName", type="string", length=155)
     *
     * @Assert\NotBlank(
     *     message="Le nom de famille est obligatoire",
     *     groups={"client_create"}
     * )
     * @Assert\Length(
     *     min=2,
     *     minMessage="Le nom de famille doit contenir plus de {{ limit }} caractères",
     *     max=70,
     *     maxMessage="Le nom de famille ne peut pas contenir plus de {{ limit }} caractères",
     *     groups={"client_create", "client_edit"}
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example" = "Doe"
     *          }
     *     }
     * )
     */
    private $lastName;

    /**
     * @var string
     * Mail address of Client
     *
     * @ORM\Column(name="mail_address", type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(
     *     message="L'adresse mail est obligatoire",
     *     groups={"client_create"}
     * )
     * @Assert\Email(
     *     message="Veuillez entrer une adresse mail valide",
     *     checkMX=true,
     *     checkHost=true,
     *     groups={"client_create", "client_edit"}
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example" = "johndoe@gmail.com"
     *          }
     *     }
     * )
     */
    private $mailAddress;

    /**
     * @var int
     * Phone number of client
     *
     * @ORM\Column(name="phone_number", type="bigint",  options={"unsigned"=true})
     *
     * @Assert\NotBlank(
     *     message="Veuillez renseigner un numéro de téléphone",
     *     groups={"client_create"}
     * )
     * @Assert\Length(
     *     min=10,
     *     max=10,
     *     exactMessage="Veuillez entrer le numéro au format français à 10 chiffres (0XXXXXXXXX)",
     *     groups={"client_create", "client_edit"}
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "integer",
     *              "example" = "0677612529"
     *          }
     *     }
     * )
     */
    private $phoneNumber;

    /**
     * Company of this user
     * @var Company
     *
     * @ORM\ManyToOne(
     *     targetEntity="Company",
     *     inversedBy="clients"
     * )
     */
    private $company;

    /**
     * @var integer
     * Used by client_create for retrieve Client Company
     *
     * @Assert\NotBlank(
     *     message="Veuillez renseigner l'id de la companie à laquelle appartient le client",
     *     groups={"client_create"}
     * )
     * @Assert\Type(
     *     type="integer",
     *     groups={"client_create", "client_edit"}
     * )
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
    private $companyId;

    // Traits
    use Hydrate;


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
     * Username of client
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

    public function normalizeClientCollection($links = true){
        $return = [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'full_name' => $this->getFullName()
        ];

        if($links) $return['links'] = $this->normalizeUserLinks();

        return $return;
    }

    public function normalizeClientItem($links = true){
        $return = [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'fist_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'mail_address' => $this->getMailAddress(),
            'phone_number' => $this->getPhoneNumber()
        ];

        if($links) $return['links'] = $this->normalizeUserLinks();

        return $return;
    }

    /**
     * @return string
     * Fullname of Client
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "string",
     *              "example" = "John Doe"
     *          }
     *     }
     * )
     */
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    private function getSelfUrl(){
        return "/clients/" . $this->getId();
    }

    public function normalizeUserLinks(){
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

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @param mixed $companyId
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
    }

}
