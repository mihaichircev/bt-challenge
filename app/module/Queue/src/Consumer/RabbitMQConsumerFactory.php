<?php

namespace Queue\Consumer;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQConsumerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config')['queue'];
        $connection = new AMQPStreamConnection(
            $config['connection']['host'],
            $config['connection']['port'],
            $config['connection']['user'],
            $config['connection']['password']
        );

        $consumer = new RabbitMQConsumer($connection);

        $handlers = [];
        foreach ($config['handlers'] as $topic => $handlerClass) {
            $handlers[$topic] = $container->get($handlerClass);
        }
        $consumer->setHandlers($handlers);

        return $consumer;
    }
}
