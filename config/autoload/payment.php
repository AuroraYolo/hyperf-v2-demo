<?php
declare(strict_types = 1);

return [
    'payment'     => [
        'default'  => [
            'sandbox'           => env('WECHAT_PAYMENT_SANDBOX', false),
            'app_id'            => env('WECHAT_PAYMENT_APPID', ''),
            'mch_id'            => env('WECHAT_PAYMENT_MCH_ID', ''),
            'key'               => env('WECHAT_PAYMENT_KEY', BASE_PATH . '/private/payment/default/apiclient_cert.pem'),
            'cert_path'         => env('WECHAT_PAYMENT_CERT_PATH', BASE_PATH . '/private/payment/default/apiclient_key.pem'),
            'key_path'          => env('WECHAT_PAYMENT_KEY_PATH', ''),
            'notify_url'        => env('WECHAT_PAYMENT_NOTIFY_URL', ''),
            'refund_notify_url' => env('WECHAT_REFUND_NOTIFY_URL', ''),
        ],
        'default1' => [
            'sandbox'           => env('WECHAT_PAYMENT_SANDBOX', false),
            'app_id'            => env('WECHAT_PAYMENT_APPID', ''),
            'mch_id'            => env('WECHAT_PAYMENT_MCH_ID', ''),
            'key'               => env('WECHAT_PAYMENT_KEY', BASE_PATH . '/private/payment/default1/apiclient_cert.pem'),
            'cert_path'         => env('WECHAT_PAYMENT_CERT_PATH', BASE_PATH . '/private/payment/default1/apiclient_key.pem'),
            'key_path'          => env('WECHAT_PAYMENT_KEY_PATH', ''),
            'notify_url'        => env('WECHAT_PAYMENT_NOTIFY_URL', ''),
            'refund_notify_url' => env('WECHAT_REFUND_NOTIFY_URL', ''),
        ]
    ],
    //服务重试次数
    'maxattempts' => 3,
    //重试休眠时间
    'sleep'       => 20

];

