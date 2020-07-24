<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\MiniProgram;

class QrCodeService extends BaseService implements Contract\QrCodeInterface
{

    /**
     * @inheritDoc
     */
    public function get(string $path, array $optional = [])
    {

    }

    /**
     * @inheritDoc
     */
    public function getUnlimit(string $scene, array $optional = [])
    {

    }

    /**
     * @inheritDoc
     */
    public function getQrCode(string $path, int $width = NULL)
    {

    }
}


