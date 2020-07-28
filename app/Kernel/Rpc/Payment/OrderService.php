<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\Payment;

use App\Exception\PaymentException;
use App\Kernel\Lock\RedisLock;
use App\Kernel\Payment\PaymentFactory;
use App\Kernel\Rpc\Payment\Contract\OrderInterface;
use Hyperf\Redis\RedisFactory;
use Hyperf\RpcServer\Annotation\RpcService;
use Hyperf\Utils\Codec\Json;
use function EasyWeChat\Kernel\Support\generate_sign;

/**
 * Class OrderService
 * @package App\Kernel\Rpc\Payment
 * @RpcService(name="OrderService",protocol="jsonrpc-tcp-length-check",server="jsonrpc",publishTo="consul")
 */
class  OrderService extends BaseService implements OrderInterface
{
    public function unify($channel, array $params, $isContract = false)
    {
        $order  = NULL;
        $return = NULL;
        if (empty($params['out_trade_no']) || empty($params['total_fee'] || empty($params['openid']))) {
            throw new PaymentException('参数不正确!');
        }
        $key       = 'order_pay_' . $channel . '_' . $params['out_trade_no'];
        $redis     = $this->container->get(RedisFactory::class)->get('default');
        $redisLock = make(RedisLock::class, [
            $redis
        ]);
        if ($redisLock->lock($key) === 0) {
            throw new PaymentException('请勿重复发起支付!');
        }
        try {
            //todo 可以自己在这里检测该订单是否被支付
            $order = retry($this->maxAttempts, function () use ($channel, $params, $isContract)
            {
                return $this->container->get(PaymentFactory::class)->get($channel)->order->unify($params, $isContract);
            }, $this->sleep);
            $redisLock->unlock($key);
            if ($order['return_code'] === 'SUCCESS' && $order['return_msg'] === 'OK') {
                // 二次验签
                $return = [
                    'appId'     => config("payment.payment.{$channel}.app_id"),
                    'timeStamp' => time(),
                    'nonceStr'  => $order['nonce_str'],
                    'package'   => 'prepay_id=' . $order['prepay_id'],
                    'signType'  => 'MD5',
                ];
                $return['paySign'] = generate_sign($return, config("payment.payment.{$channel}.key"));
            }
        } catch (\Throwable $exception) {
            $redisLock->unlock($key);
            $this->logger->error(sprintf("
            >>>>> 
            Payment:微信商户通道[%s] 统一下单[%s]发生错误, 
            错误消息:{{%s}} 
            错误行号:{{%s}} 
            错误文件:{{%s}} 
            <<<<<
            ", $channel, Json::encode($params), $exception->getMessage(), $exception->getLine(), $exception->getFile()));
        }
        finally {
            return $this->send($return);
        }
    }

    public function queryByOutTradeNumber(string $channel, string $number)
    {

    }

    public function queryByTransactionId(string $channel, string $transactionId)
    {
    }

    public function close(string $channel, string $tradeNo)
    {

    }
}


