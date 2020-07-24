<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\MiniProgram;

use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

abstract class BaseService
{
    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var int|mixed
     */
    protected int $maxAttempts;

    /**
     * @var int|mixed
     */
    protected int $sleep;

    public function __construct(ContainerInterface $container)
    {
        $this->container   = $container;
        $this->logger      = $container->get(LoggerFactory::class)->get('easywechat', 'miniprogram');
        $this->maxAttempts = config('mini_program.maxattempts');
        $this->sleep       = config('mini_program.sleep');
    }

    public function send($entity)
    {
        return $entity;
    }
}


