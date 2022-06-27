<?php

namespace User\Controller;

use Laminas\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'otp' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/otp',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action'     => 'otp',
                    ],
                ],
            ],
            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
        ],
    ],
];
