<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\Payment;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @param \Hyperf\HttpServer\Contract\RequestInterface $request
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function buildSymfonyRequest(RequestInterface $request) : Request
    {
        $get         = $request->getQueryParams();
        $post        = $request->getParsedBody();
        $cookie      = $request->getCookieParams();
        $files       = $request->getUploadedFiles();
        $server      = $request->getServerParams();
        $uploadFiles = $request->getUploadedFiles() ?? [];
        $xml         = $request->getBody()->getContents();
        /** @var \Hyperf\HttpMessage\Upload\UploadedFile $v */
        foreach ($uploadFiles as $k => $v) {
            $files[$k] = $v->toArray();
        }
        return new  Request($get, $post, [], $cookie, $files, $server, $xml);
    }
}


