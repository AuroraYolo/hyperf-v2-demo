<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Kernel\MiniProgram\SessionManager;
use App\Kernel\Rpc\MiniProgram\Contract\AuthInterface;
use App\Kernel\Rpc\MiniProgram\Contract\QrCodeInterface;
use App\Kernel\Rpc\Payment\Contract\NotifyInterface;
use App\Kernel\Rpc\Payment\Contract\OrderInterface;

class RpcController extends Controller
{
    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function session()
    {
        $channel = $this->request->input('channel', 'default');
        $code    = $this->request->input('code');
        $client  = $this->container->get(AuthInterface::class);
        $value   = $client->session($channel, $code);
        return $this->response->success($value);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function phone()
    {
        $encryptedData = $this->request->input('encryptedData', '');
        $openid        = $this->request->input('openid', '');
        $iv            = $this->request->input('iv', '');
        $channel       = $this->request->input('channel', 'default');
        $client        = $this->container->get(AuthInterface::class);
        $sessionKey    = SessionManager::get($channel, $openid);
        $value         = $client->decryptData($channel, $sessionKey, $iv, $encryptedData);
        return $this->response->success($value);
    }

    public function getFewQrCode()
    {
        $channel = $this->request->input('channel', 'default');
        $path    = $this->request->input('path', '/pages/codeBus/pages/order/index');
        $client  = $this->container->get(QrCodeInterface::class);
        $value   = $client->get($channel, $path);
        return $this->response->success($value);
    }

    public function getUnlimitQrCode()
    {
        $channel = $this->request->input('channel', 'default');
        $path    = $this->request->input('path', '/pages/codeBus/pages/order/index');
        $client  = $this->container->get(QrCodeInterface::class);
        $value   = $client->getUnlimit($channel, $path);
        return $this->response->success($value);
    }

    public function getQrCode()
    {
        $channel = $this->request->input('channel', 'default');
        $path    = $this->request->input('path', '/pages/codeBus/pages/order/index');
        $client  = $this->container->get(QrCodeInterface::class);
        $value   = $client->getQrCode($channel, $path);
        return $this->response->success($value);
    }

    public function pay()
    {
        $channel = $this->request->input('channel', 'default');
        $client  = $this->container->get(OrderInterface::class);
        $value   = $client->unify($channel, [
            'body'             => '测试测试',
            'out_trade_no'     => '2020235235235',
            'total_fee'        => 1,
            'spbill_create_ip' => \getClientIp(),
            'notify_url'       => config('payment.payment.default.notify_url'),
            'trade_type'       => 'JSAPI',
            'openid'           => 'oLtqX5PkCnFBTw_C1WUSxDwFgB50',
        ]);
        return $this->response->success($value);
    }

    public function notify()
    {
        $channel = $this->request->input('channel', 'default');
        $client  = $this->container->get(NotifyInterface::class);
        $value   = $client->handlePaidNotify($channel,$this->request);
        return $this->response->toWechatXML($value->getContent());
    }
}


