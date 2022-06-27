<?php

namespace Common\Guard;

use Common\Exception\UnauthorizedException;
use Common\Service\AuthorizationService;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\Application;
use Laminas\Mvc\MvcEvent;
use Laminas\Router\RouteMatch;

class RouteGuard extends AbstractListenerAggregate
{
    /**
     * Marker for invalid route errors
     */
    public const ERROR = 'error-unauthorized-route';

    public function __construct(private AuthorizationService $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'onRoute'], -1000);
    }

    /**
     * Event callback to be triggered on dispatch, causes application error triggering
     * in case of failed authorization check
     */
    public function onRoute(MvcEvent $event): bool
    {
        $match = $event->getRouteMatch();
        if (null !== $match) {
            /**
             * @var RouteMatch $match
             */
            $routeName = $match->getMatchedRouteName();
        } else {
            $routeName = '';
        }

        if ($this->authorizationService->isAllowed($routeName)) {
            return true;
        }
        $event->setError(static::ERROR);
        $event->setParam('route', $routeName);
        $event->setParam('exception', new UnauthorizedException('You are not authorized to access ' . $routeName));
        /**
         * @var Application $application
         */
        $application = $event->getTarget();
        $application->getEventManager()->trigger(MvcEvent::EVENT_DISPATCH_ERROR, $event);

        return false;
    }
}
