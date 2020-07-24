<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\MiniProgram;

use App\Kernel\MiniProgram\MiniProgramFactory;
use Hyperf\Utils\Codec\Json;

class QrCodeService extends BaseService implements Contract\QrCodeInterface
{

    /**
     * @inheritDoc
     */
    public function get(string $channel, string $path, array $optional = [])
    {
        $response = NULL;
        try {
            $response = retry($this->maxAttempts, function () use ($channel, $path, $optional)
            {
                return $this->container->get(MiniProgramFactory::class)->get($channel)->app_code->get($path, $optional);
            }, $this->sleep);
        } catch (\Throwable $throwable) {
            $this->logger->error(sprintf("
            >>>>> 
            EasyWechat:小程序通道[%s] {path}[%s] {optional}[%s] 获取小程序码(数量较少)发生错误,
            错误消息:{{%s}} 
            错误行号:{{%s}} 
            错误文件:{{%s}} 
            <<<<<
            ", $channel, $path, Json::encode($optional), $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        }
        finally {
            return $this->send($response);
        }
    }

    /**
     * @inheritDoc
     */
    public function getUnlimit(string $channel, string $scene, array $optional = [])
    {
        $response = NULL;
        try {
            $response = retry($this->maxAttempts, function () use ($channel, $scene, $optional)
            {
                return $this->container->get(MiniProgramFactory::class)->get($channel)->app_code->getUnlimit($scene, $optional);
            }, $this->sleep);
        } catch (\Throwable $throwable) {
            $this->logger->error(sprintf("
            >>>>> 
            EasyWechat:小程序通道[%s] {scene}[%s] {optional}[%s] 获取小程序码(数量较多)发生错误,
            错误消息:{{%s}} 
            错误行号:{{%s}} 
            错误文件:{{%s}} 
            <<<<<
            ", $channel, $scene, Json::encode($optional), $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        }
        finally {
            return $this->send($response);
        }
    }

    /**
     * @inheritDoc
     */
    public function getQrCode(string $channel, string $path, int $width = NULL)
    {
        $response = NULL;
        try {
            $response = retry($this->maxAttempts, function () use ($channel, $path, $width)
            {
                return $this->container->get(MiniProgramFactory::class)->get($channel)->app_code->getQrCode($path, $width);
            }, $this->sleep);
        } catch (\Throwable $throwable) {
            $this->logger->error(sprintf("
            >>>>> 
            EasyWechat:小程序通道[%s] {path}[%s] {width}[%s] 获取小程序码发生错误,
            错误消息:{{%s}} 
            错误行号:{{%s}} 
            错误文件:{{%s}} 
            <<<<<
            ", $channel, $path, $width, $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        }
        finally {
            return $this->send($response);
        }
    }
}


