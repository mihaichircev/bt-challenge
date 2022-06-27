<?php

use User\Entity\User;

return [
    'authorization' => [
        'roles' => [
            User::ROLE_GUEST => [
                'parent' => null
            ],
            User::ROLE_USER => [
                'parent' => User::ROLE_GUEST
            ],
        ],
        'routes' => [
            'home' => User::ROLE_GUEST,
            'login' => User::ROLE_GUEST,
            'otp' => User::ROLE_GUEST,
            'logout' => User::ROLE_USER,
        ]
    ]
];
