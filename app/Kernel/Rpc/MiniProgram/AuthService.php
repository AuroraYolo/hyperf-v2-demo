<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\MiniProgram;

use App\Exception\RuntimeException;
use App\Kernel\MiniProgram\MiniProgramFactory;
use App\Kernel\Rpc\MiniProgram\Contract\AuthInterface;
use Hyperf\RpcServer\Annotation\RpcService;

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
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string|void
     */
    public function session(string $channel, string $code)
    {
        $session = NULL;
        try {
            $session = retry($this->maxAttempts, function () use ($channel, $code)
            {
                return $this->container->get(MiniProgramFactory::class)->get($channel)->auth->session($code);
            }, $this->sleep);
            if (!is_array($session) || !isset($session['openid'])) {
                throw new RuntimeException($session['errmsg'], $session['errcode']);
            }
        } catch (\Throwable $exception) {
            $this->logger->error(sprintf("
            >>>>> 
            EasyWechat:小程序通道[%s] Code[%s]授权发生错误, 
            错误消息:{{%s}} 
            错误行号:{{%s}} 
            错误文件:{{%s}} 
            <<<<<
            ", $channel, $code, $exception->getMessage(), $exception->getLine(), $exception->getFile()));
        }
        finally {
            return $this->send($session);
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
     * @return array
     */
    public function decryptData(string $channel, string $sessionKey, string $iv, string $encrypted) : array
    {
        $decryptData = NULL;
        try {
            $decryptData = retry($this->maxAttempts, function () use ($channel, $sessionKey, $iv, $encrypted)
            {
                return $this->container->get(MiniProgramFactory::class)->get($channel)->encryptor->decryptData($sessionKey, $iv, $encrypted);
            }, $this->sleep);
        } catch (\Throwable $throwable) {
            $this->logger->error(sprintf("
            >>>>> 
            EasyWechat:小程序通道[%s] {sessionkey}[%s] {iv}[%s] {encrypted}[%s]获取手机号发生错误,
            错误消息:{{%s}} 
            错误行号:{{%s}} 
            错误文件:{{%s}} 
            <<<<<
            ", $channel, $sessionKey, $iv, $encrypted, $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        }
        finally {
            return $this->send($decryptData);
        }
    }
}


