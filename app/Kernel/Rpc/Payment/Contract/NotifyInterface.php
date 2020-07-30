<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\Payment\Contract;

use Hyperf\HttpServer\Contract\RequestInterface;

interface NotifyInterface
{
    /**
     * @param string                                       $channel
     * @param \Hyperf\HttpServer\Contract\RequestInterface $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @codeCoverageIgnore
     *
     */
    public function handlePaidNotify(string $channel, RequestInterface $request);

    /**
     *
     * @param string                                       $channel
     * @param \Hyperf\HttpServer\Contract\RequestInterface $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @codeCoverageIgnore
     */
    public function handleRefundedNotify(string $channel, RequestInterface $request);

    /**
     * @param string                                       $channel
     * @param \Hyperf\HttpServer\Contract\RequestInterface $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @codeCoverageIgnore
     */
    public function handleScannedNotify(string $channel, RequestInterface $request);
}


