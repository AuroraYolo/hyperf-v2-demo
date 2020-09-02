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

    /**
     * @param string $code
     */
    public function setCode(string $code) : void
    {
        $this->code = $code;
    }

    /**
     * @param array $data
     */
    public function setData(array $data) : void
    {
        $this->data = $data;
    }

    /**
     * @param string $msg
     */
    public function setMsg(string $msg) : void
    {
        $this->msg = $msg;
    }

    /**
     * @return string
     */
    public function getCode() : string
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getData() : array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getMsg() : string
    {
        return $this->msg;
    }
}


