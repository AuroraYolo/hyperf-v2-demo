<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\MiniProgram\Contract;

interface AuthInterface
{
    /**
     * Get session info by code.
     *
     * @param string $channel
     * @param string $code
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     */
    public function session(string $channel,string $code);
}


