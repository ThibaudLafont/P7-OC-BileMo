<?php
namespace AppBundle\EventSubscriber;

use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class HttpException implements EventSubscriberInterface
{

    /**
     * @var TwigEngine
     */
    private $twig;

    public function __construct(TwigEngine $twig){

        // Store twig in attributes
        $this->twig = $twig;

    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array(
            KernelEvents::EXCEPTION => array(
                array('testRedirection', 10)
            )
        );
    }

    public function testRedirection(GetResponseForExceptionEvent $event)
    {

        // Get HTTP StatusCode
        $statusCode = $event->getException()->getCode();

        // Handle the case where ApiPlatform set 500 status code in place of 404
        $content = $event->getException()->getMessage();                // Get the content of Exception
        if(strpos($content, "No route found") === 0) $statusCode = 404; // If message contain "No route", set 404 code

        // Get Request Content-Type header value
        $contentType = $event->getRequest()->getContentType();

        // Case where Content-Type is not defined of set to "text/html"
        if (
            $contentType === 'html' ||
            is_null($contentType)
        ){

            // If error is 0, set it to 500
            if($statusCode === 0) $statusCode = 500;

            // Then build template path with status code
            $template = '@Twig/Exception/error' . $statusCode . '.html.twig';

            // Set content-type
            $contentType = 'text/html';

        // Case where Content-Type is set to JSON, and errors are 404 or 500
        } elseif (
            $contentType === 'json' &&
            $statusCode == 404 ||
            $statusCode == 500
        ) {

            // Build template with status code
            $template = '@Twig/Exception/error' . $statusCode . '.json.twig';

            // Set content-type
            $contentType = 'application/json';

        }

        // If $template is set, then render Twig Template
        if(isset($template)){

            // Set $content for Response
            $content = $this->twig->render($template);

            // Build Response
            $response = new Response($content, $statusCode, ['content-type' => $contentType]);

            // Set response to $event
            $event->setResponse($response);
        }

    }

}
