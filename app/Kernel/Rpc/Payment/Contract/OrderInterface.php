<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\Payment\Contract;

interface OrderInterface
{
    public function unify(string $channel,array $params, $isContract = false);

    public function queryByOutTradeNumber(string $channel,string $number);

    public function queryByTransactionId(string $channel,string $transactionId);

    public function close(string $channel,string $tradeNo);
}


