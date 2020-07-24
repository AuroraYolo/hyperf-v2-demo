<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\MiniProgram;

use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

abstract class BaseService
{
    protected ContainerInterface $container;

    protected LoggerInterface $logger;

    protected int $maxAttempts;

    public function __construct(ContainerInterface $container)
    {
        $this->container   = $container;
        $this->logger      = $container->get(LoggerFactory::class)->get('easywechat', 'miniprogram');
        $this->maxAttempts = config('mini_program.maxattempts');
    }

    public function send($entity)
    {
        return $entity;
    }
}


