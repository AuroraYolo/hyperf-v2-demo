<?php

declare(strict_types = 1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use App\Kernel\Log;

return [
    'default'     => [
        'handler'    => [
            'class'       => Monolog\Handler\RotatingFileHandler::class,
            'constructor' => [
                'filename' => BASE_PATH . '/runtime/logs/hyperf.log',
                'level'    => Monolog\Logger::DEBUG,
            ],
        ],
        'formatter'  => [
            'class'       => Monolog\Formatter\LineFormatter::class,
            'constructor' => [
                'format'                => NULL,
                'dateFormat'            => 'Y-m-d H:i:s',
                'allowInlineLineBreaks' => true,
            ],
        ],
        'processors' => [
            [
                'class' => Log\AppendRequestIdProcessor::class,
            ],
        ],
    ],
    'miniprogram' => [
        'handler'    => [
            'class'       => Monolog\Handler\RotatingFileHandler::class,
            'constructor' => [
                'filename' => BASE_PATH . '/runtime/logs/hyperf.log',
                'level'    => Monolog\Logger::DEBUG,
            ],
        ],
        'formatter'  => [
            'class'       => Monolog\Formatter\LineFormatter::class,
            'constructor' => [
                'format'                => NULL,
                'dateFormat'            => 'Y-m-d H:i:s',
                'allowInlineLineBreaks' => true,
            ],
        ],
        'processors' => [
            [
                'class' => Log\AppendRequestIdProcessor::class,
            ],
        ],
    ],
    'payment'     => [
        'handler'    => [
            'class'       => Monolog\Handler\RotatingFileHandler::class,
            'constructor' => [
                'filename' => BASE_PATH . '/runtime/logs/hyperf.log',
                'level'    => Monolog\Logger::DEBUG,
            ],
        ],
        'formatter'  => [
            'class'       => Monolog\Formatter\LineFormatter::class,
            'constructor' => [
                'format'                => NULL,
                'dateFormat'            => 'Y-m-d H:i:s',
                'allowInlineLineBreaks' => true,
            ],
        ],
        'processors' => [
            [
                'class' => Log\AppendRequestIdProcessor::class,
            ],

        ]
    ]
];
