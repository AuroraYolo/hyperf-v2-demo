<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\MiniProgram;

use App\Exception\RuntimeException;
use App\Kernel\MiniProgram\MiniProgramFactory;
use App\Kernel\MiniProgram\SessionManager;
use App\Kernel\Rpc\MiniProgram\Contract\AuthInterface;
use App\Kernel\Rpc\Response;
use Hyperf\RpcServer\Annotation\RpcService;
use Hyperf\Utils\Codec\Json;

/**
 * Class AuthService
 * @package App\Kernel\Rpc\MiniProgram
 * @RpcService(name="AuthService",protocol="jsonrpc-tcp-length-check",server="jsonrpc",publishTo="consul")
 */
class AuthService extends BaseService implements AuthInterface
{
    /**
     * #小程序登录
     *
     * @param string $channel
     * @param string $code
     *
     * @return \App\Kernel\Rpc\Response
     */
    public function session(string $channel, string $code) : Response
    {
        $this->logger->debug(sprintf('>>>>> 
            MiniProgram => Auth => Session
            Channel:小程序通道[%s] Code[%s]
            <<<<<',
            $channel, $code));
        $response = make(Response::class);
        try {
            $session = retry($this->maxAttempts, function () use ($channel, $code)
            {
                return $this->container->get(MiniProgramFactory::class)->get($channel)->auth->session($code);
            }, $this->sleep);
            if (!is_array($session) || !isset($session['openid'])) {
                throw new RuntimeException($session['errmsg'], $session['errcode']);
            }
            SessionManager::set($channel, $session['openid'], $session['session_key']);
            $response->setCode(Response::RPC_RETURN_SUCCESS_CODE);
            $response->setData($session);
            $response->setMsg(Response::RPC_RETURN_MESSAGE_OK);
        } catch (\Throwable $exception) {
            $this->logger->error(sprintf("
            >>>>> 
            EasyWechat:小程序通道[%s] Code[%s]授权发生错误, 
            错误消息:{{%s}} 
            错误行号:{{%s}} 
            错误文件:{{%s}} 
            <<<<<
            ", $channel, $code, $exception->getMessage(), $exception->getLine(), $exception->getFile()));
            $response->setCode(Response::RPC_RETURN_FAIL_CODE);
            $response->setData([]);
            $response->setMsg($exception->getMessage());
        }
        finally {
            return $this->send($response);
        }
    }

    /**
     * #解密用户手机号
     *
     * @param string $channel
     * @param string $sessionKey
     * @param string $iv
     * @param string $encrypted
     *
     * @return Response
     */
    public function decryptData(string $channel, string $sessionKey, string $iv, string $encrypted) : Response
    {
        $this->logger->debug(sprintf('>>>>> 
            MiniProgram => Auth => decryptData
            Channel:小程序通道[%s] SessionKey[%s] Iv[%s] Encrypted[%s]
            <<<<<',
            $channel, $sessionKey, $iv, $encrypted));
        $response = make(Response::class);
        try {
            $decryptData = retry($this->maxAttempts, function () use ($channel, $sessionKey, $iv, $encrypted)
            {
                return $this->container->get(MiniProgramFactory::class)->get($channel)->encryptor->decryptData($sessionKey, $iv, $encrypted);
            }, $this->sleep);
            $response->setCode(Response::RPC_RETURN_SUCCESS_CODE);
            $response->setData($decryptData);
            $response->setMsg(Response::RPC_RETURN_MESSAGE_OK);
        } catch (\Throwable $throwable) {
            $this->logger->error(sprintf("
            >>>>> 
            EasyWechat:小程序通道[%s] {sessionkey}[%s] {iv}[%s] {encrypted}[%s]获取手机号发生错误,
            错误消息:{{%s}} 
            错误行号:{{%s}} 
            错误文件:{{%s}} 
            <<<<<
            ", $channel, $sessionKey, $iv, $encrypted, $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
            $response->setCode(Response::RPC_RETURN_FAIL_CODE);
            $response->setData([]);
            $response->setMsg($throwable->getMessage());
        }
        finally {
            return $this->send($response);
        }
    }
}


