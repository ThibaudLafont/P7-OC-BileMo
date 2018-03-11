<?php
namespace AppBundle\EventSubscriber;

use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class HttpException
 *
 * @package AppBundle\EventSubscriber
 */
class HttpException implements EventSubscriberInterface
{

    /**
     * Allow to render templates
     *
     * @var TwigEngine
     */
    private $twig;

    /**
     * Subscribed event
     *
     * @var GetResponseForExceptionEvent
     */
    private $event;

    /**
     * HttpException constructor.
     *
     * @param TwigEngine $twig
     */
    public function __construct(TwigEngine $twig)
    {

        // Store twig in attributes
        $this->twig = $twig;
    }

    /**
     * Array with listened events
     *
     * @return array
     */
    public static function getSubscribedEvents() : array
    {
        // return the subscribed events, their methods and priorities
        return array(
            KernelEvents::EXCEPTION => array(
                array('handleExceptions', 10)
            )
        );
    }

    /**
     * Function to execute when Exception catch
     *
     * Define and set Response to $event
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function handleExceptions(GetResponseForExceptionEvent $event)
    {

        // Store event
        $this->setEvent($event);

        // Get HTTP StatusCode
        $statusCode = $this->getStatusCode();

        // Get Request Content-Type header value
        $contentType = $event->getRequest()->getContentType();

        // Case where Content-Type is not defined of set to "text/html"
        if (
            $contentType !== 'json'
        ) {

            // Then build template path with status code
            $template =  $this->getTemplatePath($statusCode, 'html');

            // Set content-type
            $contentType = 'text/html';

        // Case where Content-Type is set to JSON, and errors are 404 or 500
        } elseif (
            $statusCode == 404 ||
            $statusCode == 405 ||
            $statusCode == 500
        ) {

            // Build template with status code
            $template = $this->getTemplatePath($statusCode, 'json');

            // Set content-type
            $contentType = 'application/json';
        }

        // If $template is set, then render Twig Template
        if (isset($template)) {

            // Set $content for Response
            $content = $this->twig->render($template);

            // Build Response
            $response = new Response($content, $statusCode, ['content-type' => $contentType]);

            // Set response to $event
           $event->setResponse($response);
        }
    }

    /**
     * Handle the definition of appropriate HTTP code
     *
     * @return int|mixed
     */
    private function getStatusCode()
    {

        // Store Exception
        $exception = $this->getEvent()->getException();

        // Store Exception code & message
        $code = $exception->getCode();
        $message = $exception->getMessage();

        // If "No route found", it's 404 or 405 http code
        if (strpos($message, "No route found") == 0 &&
            $this->getEvent()->getRequest()->getContentType() !== 'json') {

            // If isset "Method Not Allowed", 405 error
            if (strpos($message, "Method Not Allowed")) {
                $code = 405;
            }
            // Else 404 error
            else {
                $code = 404;
            }
        }

        // Only if content-type is not json and $code = 0,
        // cause we let Hydra handle other kinds of request exceptions
        if (
            $this->getEvent()->getRequest()->getContentType() !== 'json' &&
            $code == 0 
        ) {
            $code = 500;
        }

        return $code;
    }

    /**
     * Return path to template
     *
     * @param $statusCode int
     * @param $type string -Response format [html, json]
     *
     * @return string
     */
    private function getTemplatePath($statusCode, $type) : string
    {
        return '@Twig/Exception/error' . $statusCode . '.' . $type . '.twig';
    }

    /**
     * Get registred events
     *
     * @return GetResponseForExceptionEvent
     */
    public function getEvent(): GetResponseForExceptionEvent
    {
        return $this->event;
    }

    /**
     * Set registred events
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function setEvent(GetResponseForExceptionEvent $event)
    {
        $this->event = $event;
    }
}
