<?php

namespace Common;

use Common\Guard\RouteGuard;
use Common\View\Strategy\UnauthorizedStrategy;
use Laminas\Http\Request as HttpRequest;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\Container;
use Laminas\Session\SessionManager;

class Module
{
    /**
     * @return Array<mixed>
     */
    public function getConfig(): array
    {
        $config = [];
        $configs = glob(__DIR__ . '/../config/*.config.php');

        if (false !== $configs) {
            foreach ($configs as $file) {
                $config = array_merge($config, include $file);
            }
        }

        return $config;
    }

    public function onBootstrap(MvcEvent $e): void
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        // authorization
        if ($e->getRequest() instanceof HttpRequest) {
            $eventManager = $e->getTarget()->getEventManager(); // @phpstan-ignore-line
            $eventManager->attach(MvcEvent::EVENT_ROUTE, [$serviceManager->get(RouteGuard::class), 'onRoute'], -1000);
            $eventManager->attach(
                MvcEvent::EVENT_DISPATCH_ERROR,
                [$serviceManager->get(UnauthorizedStrategy::class), 'onDispatchError'],
                5000
            );
        }
        // session
        $sessionManager = new SessionManager();
        $sessionManager->start();

        Container::setDefaultManager($sessionManager);
    }
}
