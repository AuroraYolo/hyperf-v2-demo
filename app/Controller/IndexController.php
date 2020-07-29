<?php

declare(strict_types = 1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use App\Kernel\MiniProgram\MiniProgramFactory;
use Hyperf\DbConnection\Db;
use Hyperf\Redis\RedisFactory;
use Hyperf\Utils\Codec\Json;

class IndexController extends Controller
{
    public function index()
    {
//        di(RedisFactory::class)->get('default')->set('1','1');

        $user   = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();
        return $this->response->success([
            'user'    => $user,
            'method'  => $method,
            'message' => 'Hello Hyperf.',
        ]);
    }

    public function miniprogram()
    {
        $channel = $this->request->input('channel');
        ($this->container->get(MiniProgramFactory::class)->get($channel)->auth->session(('asdsadsadnjasnd')));
    }

    public function log()
    {
        //        $this->logger->info('11111111');
        retry(2, function ()
        {
            echo '111111111' . "\r\n";
            throw new \Exception('呵呵');
        }, 10);
    }
}
