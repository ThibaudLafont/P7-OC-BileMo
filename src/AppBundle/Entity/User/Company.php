<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * Company
 *
 * @ORM\Table(name="user_company")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\CompanyRepository")
 */
class Company
{
    /**
     * @var int
     * Primary key of resource
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @ApiProperty(
     *     attributes={
     *          "swagger_context"={
     *              "type" = "integer",
     *              "example": "1"
     *          }
     *     }
     * )
     */
    private $id;

    /**
     * @var string
     * Name of Company
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     *
     * @ApiProperty(
     *     attributes={
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
     * @ORM\OneToMany(
     *     targetEntity="Client",
     *     mappedBy="company"
     * )
     *
     * @ApiProperty(
     *     attributes={
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

    public function getCompanyCollection(){
        return [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];
    }

    public function getCompanyItem(){
        return [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];
    }

    public function getCompanyLinks(){
        return [
            '@self' => $this->getSelfUrl(),
            '@users' => $this->getUserSubLink()
        ];
    }

    public function getSelfUrl(){
        return "/companies/" . $this->getId();
    }

    public function getUserSubLink(){
        return $this->getSelfUrl() . "/users";
    }

    public function getCompanyUsers(){

        $return = [];

        foreach($this->getCLients() as $user){
            $insert = $user->getClientCollection();
            $insert['_links'] = $user->getUserLinks();

            $return[] = $insert;
        }

        return $return;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
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
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get users of company
     *
     * @return mixed
     */
    public function getClients(){
        return $this->clients;
    }

}
