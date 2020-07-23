<?php
declare(strict_types = 1);

use App\Kernel\Rpc\MiniProgram\Contract\AuthInterface;

return [
    'consumers' => [
        [
            // name 需与服务提供者的 name 属性相同
            'name'          => 'AuthService',
            // 服务接口名，可选，默认值等于 name 配置的值，如果 name 直接定义为接口类则可忽略此行配置，如 name 为字符串则需要配置 service 对应到接口类
            'service'       => AuthInterface::class,
            // 对应容器对象 ID，可选，默认值等于 service 配置的值，用来定义依赖注入的 key
            'id'            => AuthInterface::class,
            // 服务提供者的服务协议，可选，默认值为 jsonrpc-http
            // 可选 jsonrpc-http jsonrpc jsonrpc-tcp-length-check
            'protocol'      => 'jsonrpc-tcp-length-check',
            // 负载均衡算法，可选，默认值为 random
            'load_balancer' => 'random',
            // 这个消费者要从哪个服务中心获取节点信息，如不配置则不会从服务中心获取节点信息
            'registry'      => [
                'protocol' => 'consul',
                'address'  => 'http://127.0.0.1:8500',
            ],
            // 如果没有指定上面的 registry 配置，即为直接对指定的节点进行消费，通过下面的 nodes 参数来配置服务提供者的节点信息
            'nodes'         => [
                ['host' => '127.0.0.1', 'port' => 9504],
            ],
            // 配置项，会影响到 Packer 和 Transporter
            'options'       => [
                'connect_timeout' => 5.0,
                'recv_timeout'    => 5.0,
                'settings'        => [
                    // 根据协议不同，区分配置
                    //                                        'open_eof_split' => true,
                    //                                        'package_eof'    => "\r\n",
                    'open_length_check'     => true,
                    'package_length_type'   => 'N',
                    'package_length_offset' => 0,
                    'package_body_offset'   => 4,
                ],
                // 当使用 JsonRpcPoolTransporter 时会用到以下配置
                'pool'            => [
                    'min_connections' => 1,
                    'max_connections' => 50,
                    'connect_timeout' => 10.0,
                    'wait_timeout'    => 3.0,
                    'heartbeat'       => -1,
                    'max_idle_time'   => 60.0,
                ],
            ],
        ]
    ],
];



