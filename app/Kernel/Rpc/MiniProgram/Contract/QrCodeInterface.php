<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\MiniProgram\Contract;

interface QrCodeInterface
{
    /**
     * @param string $channel
     * @param string $path
     * @param array  $optional
     *
     * @return  array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function get(string $channel,string $path, array $optional = []);

    /**
     * @param string $channel
     * @param string $scene
     * @param array  $optional
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function getUnlimit(string $channel,string $scene, array $optional = []);

    /**
     * @param string   $channel
     * @param string   $path
     * @param null|int $width
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function getQrCode(string $channel,string $path, int $width = NULL);
}


