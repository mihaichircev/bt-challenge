<?php

namespace Common\Transport;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class FileTransportFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new FileTransport();
        $config = $container->get('config')['mail']['transport']['file'];
        $service->setConfig($config);

        return $service;
    }
}
