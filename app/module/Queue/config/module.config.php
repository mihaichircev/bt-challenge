<?php

namespace Queue;

return [
    'queue' => [
        'connection' => [
            'host' => 'bt-challenge_rabbitmq',
            'port'  => 5672,
            'user' => 'rabbitmq',
            'password' => 'rabbitmq'
        ],
        'handlers' => [
            'otp' => Handler\OtpHandler::class
        ],
        'queues' => [
            'otp' => 'otp'
        ]
    ]
];
