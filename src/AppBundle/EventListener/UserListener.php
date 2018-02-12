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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

/**
 * Class MessageListener
 * Execute actions when Doctrine work with Messages entities
 *
 * @package AppBundle\EventListener
 */
class UserListener
{

    private $encoder;

    public function __construct(UserPasswordEncoder $encoder){
        $this->encoder = $encoder;
    }

    /**
     * Before Message persist, assign user and creation date
     *
     * @param Client $user
     */
    public function prePersist($user)
    {
        $user->setPassword(
            $this->encoder->encodePassword(
                $user,
                $user->getPlainPassword()
            )
        );
    }

}
