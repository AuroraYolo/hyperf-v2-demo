[![Php Version](https://img.shields.io/badge/php-%3E=7.4-brightgreen.svg?maxAge=2592000)](https://secure.php.net/)
[![Swoole Version](https://img.shields.io/badge/swoole-%3E=4.5.2-brightgreen.svg?maxAge=2592000)](https://github.com/swoole/swoole-src)
[![Hyperf Version](https://img.shields.io/badge/hyperf-%3E=2.0.1-brightgreen.svg?maxAge=2592000)](https://github.com/hyperf/hyperf)

# 介绍
此框架是基于Swoole4.5+Hyperf2.0开发的Easywechat的一些案例，所有的服务都是基于jsonrpc来调度,jsonrpc服务注册进consul服务管理中心.可以支持多个小程序，目前暂时完成了微信小程序登录授权,集成了微信支付和获取二维码的操作。服务提供重试机制,链路追踪和服务监控。可以根据配置合理配置重试机制。

## TODO
集成easywechat的所有功能

## 疑问
可以联系我微信
![avatar](wechat.jpg)
## 联系方式
qq群658446650

## 启动
```bash
composer dump-autoload -o

php bin/hyperf start
```

## API访问
```
http://127.0.0.1:9501/rpc/session?channel=default&code=   获取会话session
http://127.0.0.1:9501/rpc/phone?  解密手机号
http://127.0.0.1:9501/rpc/getFewQrCode?  获取少量二维码
http://127.0.0.1:9501/rpc/getUnlimitQrCode? 获取多量二维码
http://127.0.0.1:9501/rpc/getQrCode? 获取小程序二维码(自定义尺寸)
http://127.0.0.1:9501/rpc/pay 发起微信支付请求
```

## 功能(所有的功能都是基于easywechat文档的API封装的)
- 小程序登录
- 小程序码
- 微信支付

## 配置
```php
[
    //是否支持多个小程序
    'enable_all'  => env('WECHAT_ENABLE_ALL', false),
    //多个小程序用参数字段接收需要获取对应小程序的配置字段
    'key'         => env('WECHAT_QUERY_KEY', 'channel'),
    //服务重试次数
    'maxattempts' => 2,
    //存储二维码文件路径
    'qrcode_path' => BASE_PATH . '/storage/',
    //重试间隔
    'sleep'       => 20,
    'config'      => [
        //小程序1的配置
        'default'  => [
            'app_id'  => env('WECHAT_MINI_PROGRAM_APPID', ''),
            'secret'  => env('WECHAT_MINI_PROGRAM_SECRET', ''),
            'token'   => env('WECHAT_MINI_PROGRAM_TOKEN', ''),
            'aes_key' => env('WECHAT_MINI_PROGRAM_AES_KEY', '')
        ],
        //小程序2的配置
        'default2' => [
            'app_id'  => env('WECHAT_MINI_PROGRAM_APPID_DEFAULT2', ''),
            'secret'  => env('WECHAT_MINI_PROGRAM_SECRET_DEFAULT2', ''),
            'token'   => env('WECHAT_MINI_PROGRAM_TOKEN_DEFAULT2', ''),
            'aes_key' => env('WECHAT_MINI_PROGRAM_AES_KEY_DEFAULT2', '')
        ]
    ]
];
```
```php

//支付配置
return [
    'payment'     => [
        'default'  => [
            'sandbox'           => env('WECHAT_PAYMENT_SANDBOX', false),//沙箱测试
            'app_id'            => env('WECHAT_PAYMENT_APPID', ''),//APPID
            'mch_id'            => env('WECHAT_PAYMENT_MCH_ID', ''), //商户ID
            'key'               => env('WECHAT_PAYMENT_KEY', BASE_PATH . '/private/payment/default/apiclient_cert.pem'),
            'cert_path'         => env('WECHAT_PAYMENT_CERT_PATH', BASE_PATH . '/private/payment/default/apiclient_key.pem'),
            'key_path'          => env('WECHAT_PAYMENT_KEY_PATH', ''),
            'notify_url'        => env('WECHAT_PAYMENT_NOTIFY_URL', ''), //支付回调地址
            'refund_notify_url' => env('WECHAT_REFUND_NOTIFY_URL', ''), //退款回调地址
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
```

## 服务监控
![avatar](./storage/0702A46032714AC6E3412C9A29C5029B.jpg)

## 链路追踪
![avatar](./storage/9A28EDE3E00DB6A665677D48D3A864B3.jpg)

