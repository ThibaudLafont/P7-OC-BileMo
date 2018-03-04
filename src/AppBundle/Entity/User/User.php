<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Asset;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 * Implement most par of logic for Doctrine Provider
 *
 * @ORM\MappedSuperclass()
 * @ORM\EntityListeners({"AppBundle\EventListener\UserListener"})
 *
 * @UniqueEntity(
 *     fields= "username",
 *     repositoryMethod="findUser",
 *     message="Ce nom d'utilisateur n'est pas disponible"
 * )
 */
abstract class User implements UserInterface, \Serializable
{
    /**
     * @var int
     * Primary key of resource
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * Username of user
     *
     * @ORM\Column(name="username", type="string", length=55, unique=true)
     *
     * @Asset\NotBlank(
     *     message="Vous devez renseigner un username",
     *     groups={"user_create"}
     * )
     * @Asset\Length(
     *     min=2,
     *     minMessage="Le nom d'utilisateur doit contenir plus de {{ limit }} caractères",
     *     max=55,
     *     maxMessage="Le nom d'utilisateur ne doit pas dépasser {{ limit }} caractères",
     *     groups={"user_create", "user_edit"}
     * )
     */
    private $username;

    /**
     * @var string
     * Bcrypt hashed pwd (though PasswordEncoderInterface)
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     * Used for user register
     *
     * @Asset\NotBlank(
     *     message="Veuillez renseigner un mot de passe",
     *     groups={"user_create"}
     * )
     * @Asset\Length(
     *     min=7,
     *     minMessage="Le mot de passe doit contenir {{ limit }} caractères minimum",
     *     max=30,
     *     maxMessage="Le mot de passe ne doit pas contenir plus de {{ limit }} caractères",
     *     groups={"user_create", "user_edit"}
     * )
     */
    private $plainPassword;

    // Authentication

    /**
     * String representation of object
     *
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize([
            $this->getId(),
            $this->getUserName(),
            $this->getPassword()
        ]);
    }

    /**
     * Constructs the object
     *
     * @param string $serialized <p>
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->userName,
            $this->password,
            ) = unserialize($serialized);
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->setPlainPassword(null);
    }


    // GETTERS / SETTERS

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
     * Set userName.
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get password
     *
     * @return string|null
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param string|null $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set plainPassword
     *
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

}
