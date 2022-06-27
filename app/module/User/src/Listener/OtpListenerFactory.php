<?php

namespace User\Listener;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Queue\Producer\RabbitMQProducer;

class OtpListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new OtpListener(
            $container->get(RabbitMQProducer::class),
            $container->get('config')['authentication']['otp']['queue']
        );
    }
}
