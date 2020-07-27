<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\Payment\Contract;

interface PaymentInterface
{
    public function pay();

    public function notify();
}


