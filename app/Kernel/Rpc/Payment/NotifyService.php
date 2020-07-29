<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\Payment;

use App\Kernel\Rpc\Payment\Contract\Closure;
use App\Kernel\Rpc\Payment\Contract\NotiifyInterface;
use Hyperf\RpcServer\Annotation\RpcService;

/**
 * Class NotifyService
 * @package App\Kernel\Rpc\Payment
 * @RpcService(name="NotifyService")
 */
class NotifyService extends BaseService implements NotiifyInterface
{

    /**
     * @param \Closure $closure
     *
     * @return \Symfony\Component\HttpFoundation\Response|void
     * @inheritDoc
     */
    public function handlePaidNotify(\Closure $closure)
    {

    }

    /**
     * @param \Closure $closure
     *
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function handleRefundedNotify(\Closure $closure)
    {

    }

    /**
     * @param \Closure $closure
     *
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function handleScannedNotify(\Closure $closure)
    {
    }
}


