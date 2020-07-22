<?php
declare(strict_types = 1);

namespace App\Kernel\MiniProgram;

use EasyWeChat\MiniProgram\Application;
use GuzzleHttp\Client;
use Hyperf\Guzzle\HandlerStackFactory;
use Psr\Container\ContainerInterface;
use Psr\SimpleCache\CacheInterface;

class  MiniProgramProxy extends Application
{
    protected string $miniProgramName;

    public function __construct(string $miniProgramName, array $config, ContainerInterface $container)
    {
        parent::__construct($config);
        $config = $this->config->get('http', []);
        $config['handler'] = $container->get(HandlerStackFactory::class)->create();
        $this->rebind('http_client', new Client($config));
        $cache = $container->get(CacheInterface::class);
        $this->rebind('cache', $cache);
        $this['guzzle_handler'] = $container->get(HandlerStackFactory::class)->create();
        $this->miniProgramName  = $miniProgramName;
    }

    public function __call($method, $args)
    {
        return parent::__call($method, $args);
    }
}


