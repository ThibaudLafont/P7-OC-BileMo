<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Asset;

/**
 * Company
 *
 * @ORM\Table(name="user_company")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\CompanyRepository")
 *
 * @UniqueEntity(
 *     "name",
 *     message="Une société portant ce nom existe déjà"
 * )
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
     *     mappedBy="company",
     *     cascade={"remove"}
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

    public function normalizeCompanyCollection($links = true){
        $return = [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];

        if($links) $return['_links'] = $this->normalizeCompanyLinks();
        return $return;
    }

    public function normalizeCompanyItem($links=true){
        $return = [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];

        if($links) $return['_links'] = $this->normalizeCompanyLinks();
        return $return;
    }

    public function normalizeCompanyLinks(){
        return [
            '@self' => $this->getSelfUrl(),
            '@users' => $this->getUserSubLink()
        ];
    }

    private function getSelfUrl(){
        return "/companies/" . $this->getId();
    }

    private function getUserSubLink(){
        return $this->getSelfUrl() . "/users";
    }

    public function normalizeCompanyUsers(){

        $return = [];

        foreach($this->getCLients() as $user){
            $insert = $user->normalizeClientCollection(true);

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
