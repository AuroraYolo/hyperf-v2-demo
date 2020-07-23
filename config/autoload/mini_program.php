<?php
declare(strict_types = 1);

return [
    //是否支持多个小程序
    'enable_all' => env('WECHAT_ENABLE_ALL', false),
    //多个小程序用参数字段接收需要获取对应小程序的配置字段
    'key'        => env('WECHAT_QUERY_KEY','channel'),
    'config'     => [
        //小程序1
        'default'  => [
            'app_id'  => env('WECHAT_MINI_PROGRAM_APPID', ''),
            'secret'  => env('WECHAT_MINI_PROGRAM_SECRET', ''),
            'token'   => env('WECHAT_MINI_PROGRAM_TOKEN', ''),
            'aes_key' => env('WECHAT_MINI_PROGRAM_AES_KEY', '')
        ],
        //小程序2
        'default2' => [
            'app_id'  => env('WECHAT_MINI_PROGRAM_APPID_DEFAULT2', ''),
            'secret'  => env('WECHAT_MINI_PROGRAM_SECRET_DEFAULT2', ''),
            'token'   => env('WECHAT_MINI_PROGRAM_TOKEN_DEFAULT2', ''),
            'aes_key' => env('WECHAT_MINI_PROGRAM_AES_KEY_DEFAULT2', '')
        ]
    ]
];


