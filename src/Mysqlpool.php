<?php


namespace Zhuxinyuang\common;


class Mysqlpool
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
        $swoole_mysql = new \Swoole\Coroutine\Mysql();
        $swoole_mysql->connect([
            'host' => config('database.hostname'),
            'port' => config('database.hostport'),
            'user' => config('database.username'),
            'password' => config('database.password'),
            'database' => config('database.database'),
        ]);
        if ($swoole_mysql == false) {
            throw new RuntimeException("failed to connect Mysql server.");
        } else {
            $this->put($swoole_mysql);
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