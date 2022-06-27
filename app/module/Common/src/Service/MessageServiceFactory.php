<?php

namespace Common\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\PhpRenderer;

class MessageServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new MessageService(new ViewModel(), $container->get('ViewRenderer'));
        $service->setConfig($container->get('config')['mail']['message']);

        return $service;
    }
}
