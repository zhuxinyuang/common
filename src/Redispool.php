<?php


namespace Zhuxinyuang\common;


class Redispool
{
    /**
     * @var \Swoole\Coroutine\Channel
     */
    protected $pool;

    /**
     * RedisPool constructor.
     * @param int $size 连接池的尺寸
     */
   public function __construct($size = 100)
    {
        $this->pool = new \Swoole\Coroutine\Channel($size);
        $redis = new \Swoole\Coroutine\Redis();
        $res = $redis->connect(config('cache.redis.host'), config('cache.redis.port'));
        if ($res == false) {
            throw new RuntimeException("failed to connect redis server.");
        } else {
            $this->put($redis);
        }

    }

   public function put($data)
    {
        $this->pool->push($data);
    }

   public function get()
    {
        return $this->pool->pop();
    }
}