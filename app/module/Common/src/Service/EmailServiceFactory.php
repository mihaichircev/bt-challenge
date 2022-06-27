<?php

namespace Common\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class EmailServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config')['mail'];
        $service = new EmailService(
            $container->get($config['transport']['default']),
            $container->get(MessageService::class)
        );

        return $service;
    }
}
