<?php

namespace Queue\Producer;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQProducerFactory implements FactoryInterface
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

        return new RabbitMQProducer($connection);
    }
}
