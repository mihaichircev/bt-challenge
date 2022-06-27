<?php

namespace Queue\Command;

return [
    'laminas-cli' => [
        'commands' => [
            'queue' => QueueCommand::class,
        ],
    ],
];
