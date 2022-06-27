<?php

namespace User\Authentication\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use User\Authentication\Session;
use User\Service\UserService;

class AuthenticationServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new AuthenticationService(
            $container->get(Session::class),
            $container->get(UserService::class)
        );

        $validators = [];
        foreach ($container->get('config')['authentication']['validators'] as $type => $validator) {
            $validators[$type] = $container->get($validator);
        }
        $service->setValidators($validators);

        return $service;
    }
}
