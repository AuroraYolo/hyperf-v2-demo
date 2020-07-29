<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\Payment\Contract;

interface NotiifyInterface
{
    /**
     * @param \Closure $closure
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @codeCoverageIgnore
     *
     * @throws \EasyWeChat\Kernel\Exceptions\Exception
     */
    public function handlePaidNotify(\Closure $closure);

    /**
     *
     * @param \Closure $closure
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @codeCoverageIgnore
     *
     */
    public function handleRefundedNotify(\Closure $closure);

    /**
     * @param \Closure $closure
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @codeCoverageIgnore
     *
     */
    public function handleScannedNotify(\Closure $closure);
}


