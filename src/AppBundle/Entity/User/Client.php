<?php
namespace AppBundle\Entity\User;

use AppBundle\Entity\Traits\Hydrate;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * Client Resource
 *
 * Represent an user of a bilemo's client company
 *
 * @ORM\Table(name="user_client")
 * @ORM\Entity("AppBundle\Repository\User\UserRepository")
 *
 * @UniqueEntity(
 *     fields= "mailAddress",
 *     message="Cette addresse mail est déjà enregistrée, peut être possédez-vous un compte ?",
 *     groups={"client_create", "client_edit"}
 * )
 */
class Client extends User
{

    /**
     * First name of client
     *
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=70)
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
     *          "jsonld_context"={
     *              "@id"="https://schema.org/givenName",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "string",
     *              "example" = "John"
     *          }
     *     }
     * )
     */
    private $firstName;

    /**
     * Last name of client
     *
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=155)
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
     *          "jsonld_context"={
     *              "@id"="https://schema.org/familyName",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "string",
     *              "example" = "Doe"
     *          }
     *     }
     * )
     */
    private $lastName;

    /**
     * Mail address of Client
     *
     * @var string
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
     *          "jsonld_context"={
     *              "@id"="https://schema.org/email",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "string",
     *              "example" = "johndoe@gmail.com"
     *          }
     *     }
     * )
     */
    private $mailAddress;

    /**
     * Phone number of client
     *
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=10)
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
     *          "jsonld_context"={
     *              "@id"="https://schema.org/telephone",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "string",
     *              "example" = "0677612529"
     *          }
     *     }
     * )
     */
    private $phoneNumber;

    /**
     * Company of this user
     *
     * @var Company
     *
     * @ORM\ManyToOne(
     *     targetEntity="Company",
     *     inversedBy="clients"
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/worksFor",
     *              "@type"="User\Company"
     *          }
     *     }
     * )
     */
    private $company;

    /**
     * Used by client_create for retrieve Client Company
     *
     * @var integer
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
    private $companyId;


    // ApiProperties methods

    /**
     * Primary key of resource
     *
     * @return int
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="http://schema.org/identifier",
     *              "@type"="@id"
     *          },
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
     * Username of client
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

    /**
     * Normalize Client for collection request
     *
     * @param bool $links -Normalize with _links
     *
     * @return array
     */
    public function normalizeClientCollection($links = true) : array
    {
        // Base
        $return = [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'full_name' => $this->getFullName()
        ];

        // If needed, add _links
        if ($links) {
            $return['_links'] = $this->normalizeUserLinks();
        }

        return $return;
    }

    /**
     * Normalize Client for item request
     *
     * @param bool $links -Normalize with _links
     *
     * @return array
     */
    public function normalizeClientItem($links = true) : array
    {
        // Base
        $return = [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'mail_address' => $this->getMailAddress(),
            'phone_number' => $this->getPhoneNumber()
        ];

        // If needed, add _links
        if ($links) {
            $return['links'] = $this->normalizeUserLinks();
        }

        return $return;
    }

    /**
     * Get fullname of Client
     *
     * @return string
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/alternateName",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "string",
     *              "example" = "John Doe"
     *          }
     *     }
     * )
     */
    private function getFullName() : string
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * Return URL to item
     *
     * @return string
     */
    private function getSelfUrl() : string
    {
        return "/clients/" . $this->getId();
    }

    /**
     * Normalize _links
     *
     * @return array
     */
    public function normalizeUserLinks() : array
    {
        return [
            '@self' => $this->getSelfUrl()
        ];
    }

    // Authorizations

    /**
     * Returns the roles granted to the user.
     *
     * @return array
     */
    public function getRoles() : array
    {
        return ['ROLE_USER'];
    }


    // GETTERS / SETTERS

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return Client
     */
    public function setFirstName(string $firstName) : Client
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName() : string
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return Client
     */
    public function setLastName(string $lastName) : Client
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName() : string
    {
        return $this->lastName;
    }

    /**
     * Set mailAddress.
     *
     * @param string $mailAddress
     *
     * @return Client
     */
    public function setMailAddress(string $mailAddress) : Client
    {
        $this->mailAddress = $mailAddress;

        return $this;
    }

    /**
     * Get mailAddress.
     *
     * @return string
     */
    public function getMailAddress() : string
    {
        return $this->mailAddress;
    }

    /**
     * Set phoneNumber.
     *
     * @param string $phoneNumber
     *
     * @return Client
     */
    public function setPhoneNumber(string $phoneNumber) : Client
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber.
     *
     * @return string
     */
    public function getPhoneNumber() : string
    {
        return $this->phoneNumber;
    }

    /**
     * Get company
     *
     * @return Company
     */
    public function getCompany() : Company
    {
        return $this->company;
    }

    /**
     * Set company
     *
     * @param Company $company
     *
     * @return Client
     */
    public function setCompany(Company $company) : Client
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get companyId
     *
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * Set companyId
     *
     * @param mixed $companyId
     *
     * @return Client
     */
    public function setCompanyId(int $companyId) : Client
    {
        $this->companyId = $companyId;

        return $this;
    }
}
