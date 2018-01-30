<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="user_partner")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\ClientRepository")
 */
class Partner extends User
{
    /**
     * @var String
     *
     * @ORM\Column(name="department", type="string", length=255)
     */
    private $department;

    /**
     * @return String
     */
    public function getDepartment(): String
    {
        return $this->department;
    }
    /**
     * @param String $department
     */
    public function setDepartment(String $department)
    {
        $this->department = $department;
    }
}
