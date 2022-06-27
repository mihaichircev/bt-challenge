<?php

namespace Common\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use User\Authentication\Service\AuthenticationService;

class AuthorizationServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new AuthorizationService($container->get(AuthenticationService::class));
        $service->setConfig($container->get('config')['authorization']);

        return $service;
    }
}
