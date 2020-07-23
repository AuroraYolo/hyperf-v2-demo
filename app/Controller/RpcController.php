<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Kernel\Rpc\MiniProgram\Contract\AuthInterface;

class RpcController extends Controller
{
    public function session()
    {
        $channel = $this->request->input('channel');
        $code    = $this->request->input('code');
        $client  = $this->container->get(AuthInterface::class);
        $value   = $client->session($channel, $code);
        return $this->response->success($value);
    }
}


