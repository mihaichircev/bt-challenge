<?php

namespace User\Command;

return [
    'laminas-cli' => [
        'commands' => [
            'create-user' => CreateUserCommand::class,
        ],
    ],
];
