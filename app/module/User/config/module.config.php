<?php

namespace User;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use User\Authentication\OtpSender\OtpSenderEmail;
use User\Authentication\Service\AuthenticationService;
use User\Authentication\Validator\CredentialsValidator;
use User\Authentication\Validator\OtpValidator;
use User\Authentication\Validator\OtpLimitValidator;

return [
    'authentication' => [
        'validators' => [
            AuthenticationService::CHECK_CREDENTIALS => CredentialsValidator::class,
            AuthenticationService::CHECK_OTP_LIMIT => OtpLimitValidator::class,
            AuthenticationService::CHECK_OTP => OtpValidator::class
        ],
        'otp' => [
            'sender' => OtpSenderEmail::class,
            'queue' => 'otp',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'memcached',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ]
    ],
];
