<?php

namespace Queue\Command;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Queue\Consumer\RabbitMQConsumer;

class QueueCommandFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config')['queue'];

        $command = new QueueCommand($container->get(RabbitMQConsumer::class));
        $command->setConfig($config);

        return $command;
    }
}
