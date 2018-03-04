<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 09/12/17
 * Time: 14:52
 */

namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User\Client;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class MessageListener
 * Execute actions when Doctrine work with Messages entities
 *
 * @package AppBundle\EventListener
 */
class UserListener
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    /**
     * Before Message persist, assign user and creation date
     *
     * @param Client $user
     */
    public function prePersist($user)
    {
        $this->setUserPassword($user);
    }

    /**
     * Before User update, check if password was changed
     *
     * @param $user
     */
    public function preFlush($user){

        // Check if password was submitted
        if($user->getPlainPassword() !== null){

            // Encode and set password
            $this->setUserPassword($user);
        }

    }

    private function setUserPassword($user){

        // Set user password
        $user->setPassword(
            // Encode pwd
            $this->encoder->encodePassword(
                $user,
                $user->getPlainPassword() // From plainPassword
            )
        );

    }

}
