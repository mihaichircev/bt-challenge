<?php

namespace Common;

return [
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'common/index/index' => __DIR__ . '/../view/common/index/index.phtml',
            'email/otp-token' => __DIR__ . '/../view/email/otp-token.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'view_helper_config' => [
        'flashmessenger' => [
            'message_open_format'      => '<div%s><button type="button" class="close" ' .
                'data-dismiss="alert" aria-hidden="true">&times;</button><div>',
            'message_close_string'     => '</div></div>',
            'message_separator_string' => '</div><div>',
        ],
    ],
];
