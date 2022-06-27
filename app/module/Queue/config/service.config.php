<?php

namespace Queue;

return [
    'service_manager' => [
        'factories' => [
            Command\QueueCommand::class => Command\QueueCommandFactory::class,
            Consumer\RabbitMQConsumer::class => Consumer\RabbitMQConsumerFactory::class,
            Handler\OtpHandler::class => Handler\OtpHandlerFactory::class,
            Producer\RabbitMQProducer::class => Producer\RabbitMQProducerFactory::class,
        ],
    ],
];
