<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\MiniProgram;

use App\Kernel\MiniProgram\MiniProgramFactory;
use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

abstract class BaseService
{
    protected ContainerInterface $container;

    protected LoggerInterface $logger;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger    = $container->get(LoggerFactory::class)->get('easywechat', 'miniprogram');
    }

    public function send($entity)
    {
        return $entity;
    }
}


