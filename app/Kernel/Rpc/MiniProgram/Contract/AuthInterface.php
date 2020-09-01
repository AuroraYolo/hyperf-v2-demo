<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\MiniProgram\Contract;

use App\Kernel\Rpc\Response;

interface AuthInterface
{
    /**
     * Get session info by code.
     *
     * @param string $channel
     * @param string $code
     *
     * @return \App\Kernel\Rpc\Response
     */
    public function session(string $channel, string $code):Response;

    /**
     * @param string $channel
     * @param string $sessionKey
     * @param string $iv
     * @param string $encrypted
     *
     * @return array
     */
    public function decryptData(string $channel, string $sessionKey, string $iv, string $encrypted) :Response;
}


