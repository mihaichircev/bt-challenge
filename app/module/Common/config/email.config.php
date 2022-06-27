<?php

use Common\Service\MessageService;
use Common\Transport\FileTransport;

return [
    'mail' => [
        'message' => [
            'from' => 'no-reply@bt-challenege.app',
            'from_name' => 'BT Challenge App',
            'types' => [
                MessageService::TYPE_OTP_TOKEN => [
                    'subject' => 'Login access code',
                    'template' => 'email/otp-token'
                ]
            ]
        ],
        'transport' => [
            'default' => FileTransport::class,
            'smtp' => [
                'server' => '',
                'smtp_user' => '',
                'smtp_password' => '',
                'ssl' => 'ssl',
                'connection_class' => 'login',
                'port' => 465,
            ],
            'file' => [
                'path' => __DIR__ . '/../../../data/message'
            ]
        ],
    ],
];
