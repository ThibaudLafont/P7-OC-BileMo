<?php
namespace AppBundle\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class HttpException
 *
 * @package AppBundle\EventSubscriber
 */
class CacheControl implements EventSubscriberInterface
{

    /**
     * Subscribed event
     *
     * @var GetResponseForExceptionEvent
     */
    private $event;
    /**
     * Array with listened events
     *
     * @return array
     */
    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::VIEW => ['setCacheControl', EventPriorities::PRE_RESPOND],
        ];
    }

    /**
     * Function to execute when Exception catch
     *
     * Define and set Response to $event
     *
     * @param GetResponseForControllerResultEvent $event
     */
    public function setCacheControl(GetResponseForControllerResultEvent $event)
    {
        // Get Content and request uri from event
        $content = $event->getControllerResult();
        $url = $event->getRequest()->getRequestUri();

        // Build response from ControllerResult
        $resp = new Response($content);

        // If sensible road, add Cache-Control:no-cache and setPrivate
        if(
            $url == "/users"    ||
            $url == "/clients"  ||
            $url == "/partners" ||
            $url == "/login_check" ||
            preg_match("@^/companies*@", $url)
        ) {

            $resp->headers->set('Cache-Control', 'no-cache');
            $resp->setPrivate();

        // Else, set public
        }else {
            $resp->setPublic();
        }

        // Set Response
        $event->setResponse($resp);

    }

}
