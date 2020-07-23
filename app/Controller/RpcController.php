<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Kernel\Rpc\MiniProgram\Contract\AuthInterface;

class RpcController extends Controller
{
    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function session()
    {
        $channel = $this->request->input('channel');
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
        $iv            = $this->request->input('iv', '');
        $channel       = $this->request->input('channel', 'default');
        $client        = $this->container->get(AuthInterface::class);
        $value         = $client->decryptData($channel, '', $iv, $encryptedData);
        return $this->response->success($value);
    }
}


