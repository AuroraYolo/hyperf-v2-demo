<?php
declare(strict_types = 1);

return [
    'payment' => [
        'default' => [
            'sandbox'           => env('WECHAT_PAYMENT_SANDBOX', false),
            'app_id'            => env('WECHAT_PAYMENT_APPID', ''),
            'mch_id'            => env('WECHAT_PAYMENT_MCH_ID', ''),
            'key'               => env('WECHAT_PAYMENT_KEY', ''),
            'cert_path'         => env('WECHAT_PAYMENT_CERT_PATH', ''),
            'key_path'          => env('WECHAT_PAYMENT_KEY_PATH', ''),
            'notify_url'        => env('WECHAT_PAYMENT_NOTIFY_URL', ''),
            'refund_notify_url' => env('WECHAT_REFUND_NOTIFY_URL', ''),
        ],
    ]
];

