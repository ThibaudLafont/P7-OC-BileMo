<?php
namespace AppBundle\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use ApiPlatform\Core\Exception\ItemNotFoundException;
use AppBundle\Entity\User\Client;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ClientCreate
 *
 * Used for retrieve and assign Company resource to Client at creation
 *
 * @package AppBundle\EventSubscriber
 */
final class ClientCreate implements EventSubscriberInterface
{

    /**
     * Used for find Company with given ID
     *
     * @var EntityManager
     */
    private $em;

    /**
     * Store EntityManager in attributes
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Define witch event is listen
     *
     * @return array
     */
    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::VIEW => ['setCompany', EventPriorities::POST_VALIDATE],
        ];
    }

    /**
     * Retrieve Company though companyId
     *
     * @param GetResponseForControllerResultEvent $event
     */
    public function setCompany(GetResponseForControllerResultEvent $event)
    {
        // Store Client and Method from response
        $client = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        // Return if object is not client
        if (!$client instanceof Client || Request::METHOD_POST !== $method) {
            return;
        }

        // Fetch and store Company
        $company = $this->em->getRepository('AppBundle:User\Company')->find($client->getCompanyId());
        // If no match, throw new exception
        if (is_null($company)) {
            throw new ItemNotFoundException("Aucune companie connue avec cet id", 404);
        }

        // Assign company to client
        $client->setCompany($company);
    }
}
