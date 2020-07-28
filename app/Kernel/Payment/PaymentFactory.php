<?php
declare(strict_types = 1);

namespace App\Kernel\Payment;

use App\Exception\InvalidPaymentProxyException;
use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;

class PaymentFactory
{
    /**
     * @var PaymentProxy[]
     */
    protected array $proxies;

    public function __construct(ConfigInterface $config, ContainerInterface $container)
    {
        $paymentConfig = $config->get('payment.payment');
        foreach ($paymentConfig as $name => $item) {
            $this->proxies[$name] = make(PaymentProxy::class, [
                'paymentName' => $name,
                'config'      => $item,
                'container'   => $container
            ]);
        }
    }

    /**
     * @param string $paymentName
     *
     * @return PaymentProxy
     */
    public function get(string $paymentName = 'default') : ?PaymentProxy
    {
        $proxy = $this->proxies[$paymentName] ?? NULL;
        if (!$proxy instanceof PaymentProxy) {
            throw new InvalidPaymentProxyException('Invalid Payment proxy.');
        }
        return $proxy;
    }
}


