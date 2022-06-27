<?php

namespace Common\View\Strategy;

use Common\Guard\RouteGuard;
use Laminas\EventManager\Event;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\Http\Response as HttpResponse;
use Laminas\Mvc\MvcEvent;
use Laminas\Stdlib\ResponseInterface as Response;
use Laminas\View\Model\ViewModel;

/**
 * Dispatch error handler, catches exceptions related with authorization and
 * configures the application response accordingly.
 */
class UnauthorizedStrategy implements ListenerAggregateInterface
{
    protected string $template = 'error/404';

    /**
     * @var callable[]
     */
    protected $listeners = [];

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'onDispatchError'], -5000);
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

    public function setTemplate(string $template): void
    {
        $this->template = (string) $template;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Callback used when a dispatch error occurs. Modifies the
     * response object with an according error if the application
     * event contains an exception related with authorization.
     */
    public function onDispatchError(Event $event): null|MvcEvent
    {
        /**
         * @var MvcEvent $mvcEvent
         */
        $mvcEvent = $event instanceof MvcEvent ? $event : $event->getTarget();

        if ($mvcEvent->getError() === RouteGuard::ERROR) {
            $response = $mvcEvent->getResponse();
            if ($response instanceof HttpResponse) {
                return null;
            } else {
                $response = new HttpResponse();
            }
            $model = new ViewModel();
            $model->setTemplate($this->getTemplate());
            $mvcEvent->getViewModel()->addChild($model);
            $response->setStatusCode(403);
            $mvcEvent->setResponse($response);
            $event->stopPropagation();

            return $mvcEvent;
        }

        return null;
    }
}
