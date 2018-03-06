<?php
namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User\Client;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class MessageListener
 *
 * Execute actions when Doctrine work with Messages entities
 *
 * @package AppBundle\EventListener
 */
class UserListener
{

    /**
     * Password encoder
     *
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserListener constructor.
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Before Message persist, assign user and creation date
     *
     * @param User $user
     */
    public function prePersist($user)
    {
        $this->setUserPassword($user);
    }

    /**
     * Before User update, check if password was changed
     *
     * @param $user User
     */
    public function preFlush($user)
    {

        // Check if password was submitted
        if ($user->getPwd() !== null) {

            // Encode and set password
            $this->setUserPassword($user);
        }
    }

    /**
     * Encode and set password from plainPassword
     *
     * @param $user User
     */
    private function setUserPassword($user)
    {

        // Set user password
        $user->setPassword(
            // Encode pwd
            $this->encoder->encodePassword(
                $user,
                $user->getPwd() // From plainPassword
            )
        );
    }
}
