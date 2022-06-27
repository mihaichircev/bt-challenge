<?php

namespace User;

use Common\Service\ServiceManagerReflectionFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            Authentication\OtpSender\OtpSenderEmail::class => ServiceManagerReflectionFactory::class,
            Authentication\Service\AuthenticationService::class =>
                Authentication\Service\AuthenticationServiceFactory::class,
            Authentication\Session::class => InvokableFactory::class,
            Authentication\Validator\CredentialsValidator::class => ServiceManagerReflectionFactory::class,
            Authentication\Validator\OtpValidator::class => ServiceManagerReflectionFactory::class,
            Authentication\Validator\OtpLimitValidator::class => ServiceManagerReflectionFactory::class,
            Command\CreateUserCommand::class  => ServiceManagerReflectionFactory::class,
            Listener\OtpListener::class  => Listener\OtpListenerFactory::class,
            Service\OtpService::class => ServiceManagerReflectionFactory::class,
            Service\UserService::class => ServiceManagerReflectionFactory::class,
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class => ServiceManagerReflectionFactory::class,
        ]
    ],
    'view_helpers' => [
        'factories' => [
            View\Helper\AuthenticationHelper::class => ServiceManagerReflectionFactory::class,
        ],
        'aliases' => [
            'authentication' => View\Helper\AuthenticationHelper::class,
        ]
    ],
];
