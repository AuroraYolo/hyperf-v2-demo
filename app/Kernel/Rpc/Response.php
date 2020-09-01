<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc;

class Response
{
    const RPC_RETURN_SUCCESS_CODE = 'SUCCESS';
    const RPC_RETURN_FAIL_CODE = 'FAIL';
    const RPC_RETURN_MESSAGE_OK = 'OK';

    public string $code = 'SUCCESS';

    public array $data = [];

    public string $msg = self::RPC_RETURN_MESSAGE_OK;

    public function __construct(string $code, array $data, string $msg)
    {
        $this->code = $code;
        $this->data = $data;
        $this->msg  = $msg;
    }
}


