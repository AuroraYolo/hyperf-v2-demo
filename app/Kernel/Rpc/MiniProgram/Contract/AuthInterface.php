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
    public function session(string $channel, string $code);

    /**
     * @param string $channel
     * @param string $sessionKey
     * @param string $iv
     * @param string $encrypted
     *
     * @return array
     */
    public function decryptData(string $channel, string $sessionKey, string $iv, string $encrypted) : array;
}


