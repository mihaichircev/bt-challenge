<?php

namespace Common;

use Doctrine\ORM\EntityManager;
use Laminas\Mail\Transport\Smtp;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ]
    ],
    'service_manager' => [
        'factories' => [
            'memcached' => Service\MemcachedServiceFactory::class,
            Service\EmailService::class => Service\EmailServiceFactory::class,
            Guard\RouteGuard::class => Service\ServiceManagerReflectionFactory::class,
            Service\AuthorizationService::class => Service\AuthorizationServiceFactory::class,
            Service\MessageService::class => Service\MessageServiceFactory::class,
            Smtp::class => Transport\SmtpTransportFactory::class,
            Transport\FileTransport::class => Transport\FileTransportFactory::class,
            View\Strategy\UnauthorizedStrategy::class => Service\ServiceManagerReflectionFactory::class,
        ],
        'aliases' => [
            EntityManager::class => 'doctrine.entitymanager.orm_default',
        ]
    ],
];
