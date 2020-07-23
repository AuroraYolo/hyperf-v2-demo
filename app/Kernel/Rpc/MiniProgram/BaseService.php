<?php
declare(strict_types = 1);

namespace App\Kernel\Rpc\MiniProgram;

abstract class BaseService
{
    public function send($entity)
    {
        return $entity;
    }
}


