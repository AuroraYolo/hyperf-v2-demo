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
     * @param string $fileName
     *
     * @return  array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function get(string $channel,string $path, array $optional = [],string $fileName = '');

    /**
     * @param string $channel
     * @param string $scene
     * @param array  $optional
     *
     * @param string $fileName
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function getUnlimit(string $channel,string $scene, array $optional = [],string $fileName = '');

    /**
     * @param string   $channel
     * @param string   $path
     * @param null|int $width
     *
     * @param string   $fileName
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function getQrCode(string $channel,string $path, int $width = NULL,string $fileName = '');
}


