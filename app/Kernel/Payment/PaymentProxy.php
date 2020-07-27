<?php
declare(strict_types = 1);

namespace App\Kernel\Payment;

use EasyWeChat\Payment\Application;
use GuzzleHttp\Client;
use Hyperf\Guzzle\HandlerStackFactory;
use Psr\Container\ContainerInterface;
use Psr\SimpleCache\CacheInterface;

class PaymentProxy extends Application
{
    protected string $paymentName;

    public function __construct(string $paymentName, array $config, ContainerInterface $container)
    {
        parent::__construct($config);
        $config            = $this->config->get('http', []);
        $config['handler'] = $container->get(HandlerStackFactory::class)->create();
        $this->rebind('http_client', new Client($config));
        $cache = $container->get(CacheInterface::class);
        $this->rebind('cache', $cache);
        $this['guzzle_handler'] = $container->get(HandlerStackFactory::class)->create();
        $this->paymentName      = $paymentName;
    }

    public function __call($name, $arguments)
    {
        return parent::__call($name, $arguments);
    }
}


