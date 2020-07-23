<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\MiniProgram;

use App\Kernel\MiniProgram\MiniProgramFactory;
use App\Kernel\Rpc\MiniProgram\Contract\AuthInterface;
use Hyperf\Logger\LoggerFactory;
use Hyperf\RpcServer\Annotation\RpcService;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AuthService
 * @package App\Kernel\Rpc\MiniProgram
 * @RpcService(name="AuthService",protocol="jsonrpc-tcp-length-check",server="jsonrpc",publishTo="consul")
 */
class AuthService extends BaseService implements AuthInterface
{
    protected ContainerInterface $container;

    protected LoggerInterface $logger;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger    = $container->get(LoggerFactory::class)->get('easywechat', 'miniprogram');
    }

    /**
     * @param string $channel
     * @param string $code
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string|void
     */
    public function session(string $channel, string $code)
    {

        $session = NULL;
        try {
            $session = $this->container->get(MiniProgramFactory::class)->get($channel)->auth->session($code);
        } catch (\Throwable $exception) {
            $this->logger->error(sprintf("
            EasyWechat:获取小程序通道[%s] Code[%s]授权发生错误, \n
            {{%s}} \n
            {{%s}} \n
            {{%s}} \n
            ", $channel, $code, $exception->getMessage(), $exception->getLine(), $exception->getFile()));
        }
        finally {
            return $this->send($session);
        }
    }
}


