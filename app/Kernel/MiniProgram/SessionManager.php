<?php
declare(strict_types = 1);
namespace App\Kernel\MiniProgram;

use Hyperf\Redis\RedisFactory;

class SessionManager
{

    public const SESSION_PREFIX = 'mini_program:';

    /**
     * @param string $channel
     * @param string $id
     * @param string $session
     *
     * @return bool
     */
    public static function set(string $channel, string $id, string $session) : bool
    {
        $redis = di(RedisFactory::class)->get($channel);
        return $redis->setex(md5(self::SESSION_PREFIX . $channel . $id), 5 * 30, $session);
    }

    /**
     * @param string $channel
     * @param string $id
     *
     * @return bool|mixed|string
     */
    public static function get(string $channel, string $id)
    {
        $redis = di(RedisFactory::class)->get($channel);
        return $redis->get(md5(self::SESSION_PREFIX . $channel . $id));
    }

    /**
     * @param string $channel
     * @param string $id
     *
     * @return int
     */
    public static function del(string $channel, string $id)
    {
        $redis = di(RedisFactory::class)->get($channel);
        return $redis->del(md5(self::SESSION_PREFIX . $channel . $id));
    }
}


