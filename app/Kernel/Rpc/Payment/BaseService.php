<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\Payment;

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
        $this->logger      = $container->get(LoggerFactory::class)->get('easywechat', 'payment');
        $this->maxAttempts = config('payment.maxattempts');
        $this->sleep       = config('payment.sleep');
    }

    public function send($entity)
    {
        return $entity;
    }
}


