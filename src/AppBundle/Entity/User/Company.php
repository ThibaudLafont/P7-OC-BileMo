<?php
namespace AppBundle\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Asset;

/**
 * Company
 *
 * @package AppBundle\Entity\User
 *
 * @ORM\Table(name="user_company")
 * @ORM\Entity()
 *
 * @UniqueEntity(
 *     "name",
 *     message="Une société portant ce nom existe déjà"
 * )
 */
class Company
{

    /**
     * Primary key of resource
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/identifier",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "integer",
     *              "example": "1"
     *          }
     *     }
     * )
     */
    private $id;

    /**
     * Name of Company
     *
     * @var string
     *
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=255,
     *     unique=true
     * )
     *
     * @Asset\NotBlank(
     *     message="Veuillez indiquer le nom de la société"
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="http://schema.org/name",
     *              "@type"="@id"
     *          },
     *          "swagger_context"={
     *              "type" = "string",
     *              "example": "Wefix"
     *          }
     *     }
     * )
     */
    private $name;

    /**
     * Users linked to company
     *
     * @var mixed
     *
     * @ORM\OneToMany(
     *     targetEntity="Client",
     *     mappedBy="company",
     *     cascade={"remove"}
     * )
     *
     * @ApiProperty(
     *     attributes={
     *          "jsonld_context"={
     *              "@id"="https://schema.org/employee",
     *              "@type"="User\Client"
     *          },
     *          "swagger_context"={
     *              "type" = "array",
     *              "items" = {
     *                  "$ref"="#/definitions/Client-client_list"
     *              }
     *          }
     *     }
     * )
     */
    private $clients;

    /**
     * Normalize Company for collection request
     *
     * @param bool $links -Normalize with _links
     *
     * @return array
     */
    public function normalizeCompanyCollection($links = true) : array
    {
        // Base
        $return = [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];

        // If links needed, add them
        if ($links) {
            $return['_links'] = $this->normalizeCompanyLinks();
        }

        return $return;
    }

    /**
     * Normalize Company for item request
     *
     * @param bool $links -Normalize with _links
     *
     * @return array
     */
    public function normalizeCompanyItem($links=true) : array
    {
        // Base
        $return = [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];

        // If links needed, add them
        if ($links) {
            $return['_links'] = $this->normalizeCompanyLinks();
        }

        return $return;
    }

    /**
     * Normalize _links
     *
     * @return array
     */
    public function normalizeCompanyLinks() : array
    {
        return [
            '@self' => $this->getSelfUrl(),
            '@users' => $this->getUserSubLink()
        ];
    }

    /**
     * Get URL to item
     *
     * @return string
     */
    private function getSelfUrl() : string
    {
        return "/companies/" . $this->getId();
    }

    /**
     * Get URL to Users subresource
     *
     * @return string
     */
    private function getUserSubLink() : string
    {
        return $this->getSelfUrl() . "/users";
    }

    /**
     * Normalize Clients of Company
     *
     * @return array
     */
    public function normalizeCompanyUsers() : array
    {

        // Init empty array
        $return = [];

        // Loop on every Company Client
        foreach ($this->getClients() as $user) {

            // Fetch and store Client normalization
            $insert = $user->normalizeClientCollection(true);

            // Add Client in return array
            $return[] = $insert;
        }

        return $return;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Company
     */
    public function setName(string $name) : Company
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get users of company
     *
     * @return mixed
     */
    public function getClients()
    {
        return $this->clients;
    }
}
