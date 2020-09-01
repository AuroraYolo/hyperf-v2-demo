<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\Payment;

use App\Constants\Payment;
use App\Kernel\Payment\PaymentFactory;
use App\Kernel\Rpc\Payment\Contract\Closure;
use App\Kernel\Rpc\Payment\Contract\NotifyInterface;
use App\Kernel\Rpc\Payment\Contract\OrderInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\RpcServer\Annotation\RpcService;
use Hyperf\Utils\Arr;
use Hyperf\Utils\Codec\Json;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotifyService
 * @package App\Kernel\Rpc\Payment
 * @RpcService(name="NotifyService",protocol="jsonrpc-tcp-length-check",server="jsonrpc",publishTo="consul")
 */
class NotifyService extends BaseService implements NotifyInterface
{

    /**
     * @param string                                       $channel
     * @param \Hyperf\HttpServer\Contract\RequestInterface $request
     *
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function handlePaidNotify(string $channel, RequestInterface $request)
    {
        $response = NULL;
        try {
            $symfonyRequest                                                        = $this->buildSymfonyRequest($request);
            $this->container->get(PaymentFactory::class)->get($channel)['request'] = $symfonyRequest;
            $response                                                              = $this->container->get(PaymentFactory::class)->get($channel)->handlePaidNotify(function ($message, $fail) use ($channel)
            {
                $this->logger->debug(sprintf('
            >>>>> 
            Payment => Notify => HandlePaidNotify
            支付回调:
            Channel:微信商户通道[%s] Message:[%s]
            <<<<<
            ', $channel, Json::encode($message)));

                $client = $this->container->get(OrderInterface::class);
                $query  = $client->queryByOutTradeNumber($channel, $message['out_trade_no']);
                if ($query['return_code'] === Payment::FAIL_TEXT) {
                    $this->logger->error(sprintf('
                >>>>>
                Channel:[%s] 查询微信订单API错误
                订单号:[%s]
                错误原因:[%s]
                <<<<<
                ', $channel, $message['out_trade_no'], $query['return_msg']));
                    return false;
                }
                $this->logger->info(sprintf('
            >>>>>
            Channel:[%s]
            订单号:[%s]
            OPENID:[%s]
            订单金额:[%s]
            支付结果:[%s]
            错误代码:[%s]
            错误代码描述:[%s]
            <<<<<
            ', $message['out_trade_no'],
                    $message['openid'],
                    $message['total_fee'],
                    $message['result_code'],
                    $message['err_code'] ?? '',
                    $message['err_code_des'] ?? ''));
                if ($message['result_code'] === Payment::SUCCESS_TEXT) {
                    if (Arr::get($message, 'result_code') === Payment::SUCCESS_TEXT) {
                        return true;
                    } else {
                        if (Arr::get($message, 'result_code') === Payment::FAIL_TEXT) {
                            return false;
                        }
                    }
                } else {
                    return $fail('通信失败，请稍后再通知!');
                }
            });
        } catch (\Throwable $exception) {
            $this->logger->error(sprintf('>>>>>
            微信支付回调错误:
            Channel:[%s]
            错误消息:{{%s}} 
            错误行号:{{%s}} 
            错误文件:{{%s}} 
            <<<<<', $channel, $exception->getMessage(), $exception->getLine(), $exception->getFile()));
        }
        finally {
            return $this->send($response instanceof Response ? $response : NULL);
        }
    }

    public function handleRefundedNotify(string $channel, RequestInterface $request)
    {
        $response = NULL;
        try {
            $symfonyRequest                                                        = $this->buildSymfonyRequest($request);
            $this->container->get(PaymentFactory::class)->get($channel)['request'] = $symfonyRequest;
            $response                                                              = $this->container->get(PaymentFactory::class)->get($channel)->handleRefundedNotify(function ($message, $reqInfo, $fail) use ($channel)
            {
                $this->logger->debug(sprintf('
            >>>>> 
            Payment => Notify => HandlePaidNotify
            退款回调:
            Channel:微信商户通道[%s] Message:[%s]
            <<<<<
            ', $channel, Json::encode($message)));
                if(isset($message['return_code'])&&$message['return_code']==='SUCCESS'){
                    if (!is_array($reqInfo) && !isset($reqInfo['out_refund_no'])) {
                        return $fail('参数格式校验错误');
                    }
                    //TODO 处理回调逻辑
                    $this->logger->info(sprintf(''));
                }


            });
        } catch (\Throwable $exception) {
            $this->logger->error(sprintf('>>>>>
            微信退款回调错误:
            Channel:[%s]
            错误消息:{{%s}} 
            错误行号:{{%s}} 
            错误文件:{{%s}} 
            <<<<<', $channel, $exception->getMessage(), $exception->getLine(), $exception->getFile()));
        }
        finally {
            return $this->send($response instanceof Response ? $response : NULL);
        }
    }

    public function handleScannedNotify(string $channel, RequestInterface $request)
    {
    }

}


