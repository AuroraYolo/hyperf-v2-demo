<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\MiniProgram;

use App\Kernel\Rpc\Response;
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

    /**
     * @var string
     */
    protected string $qrCodePath;

    public function __construct(ContainerInterface $container)
    {
        $this->container   = $container;
        $this->logger      = $container->get(LoggerFactory::class)->get('easywechat', 'miniprogram');
        $this->maxAttempts = config('mini_program.maxattempts');
        $this->sleep       = config('mini_program.sleep');
        $this->qrCodePath  = config('mini_program.qrcode_path');
    }

    public function send(Response $response)
    {
        return $response;
    }
}


