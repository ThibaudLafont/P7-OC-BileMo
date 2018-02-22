<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * Company
 *
 * @ApiResource(
 *     collectionOperations={
 *          "company_list"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"company_list"}
 *              }
 *          }
 *     },
 *     itemOperations={
 *          "company_show"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"company_show"}
 *              }
 *          },
 *          "company_users"={
 *              "method"="GET",
 *              "route_name"="company_users",
 *              "path"="/company/{id}/users",
 *              "normalization_context"={
 *                  "groups"={"company_users"}
 *              }
 *          }
 *     }
 * )
 *
 * @ORM\Table(name="user_company")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\CompanyRepository")
 */
class Company
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"company_list", "company_show"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     *
     * @Groups({"company_list", "company_show"})
     */
    private $name;

    /**
     * Users linked to company
     *
     * @ORM\OneToMany(
     *     targetEntity="Client",
     *     mappedBy="company"
     * )
     */
    private $users;

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

        foreach($this->getUsers() as $user){
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
    public function getUsers(){
        return $this->users;
    }

}
