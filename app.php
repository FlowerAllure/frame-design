<?php

use Core\IOC;
use Core\Response;
use Psr\Container\ContainerInterface;

define('FRAME_START_TIME', microtime(true)); // 开始时间
define('FRAME_START_MEMORY', memory_get_usage()); // 开始内存

class App implements ContainerInterface
{
    use IOC;

    private static App $instance;

    private function __construct()
    {
        self::$instance = $this;
        $this->register();
        $this->boot();
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function get(string $id): mixed
    {
        return $this->has($id) ? $this->instances[$id] : $this->make($id);
    }

    public function has(string $id): bool
    {
        return isset($this->instances[$id]);
    }

    public static function getContainer(): App
    {
        return self::$instance ?? self::$instance = new self();
    }

    // 注册绑定
    protected function register(): void
    {
        $registers = [
            'response' => Response::class
        ];
        foreach ($registers as $name => $register) {
            $this->bind($name, $register, true);
        }
    }

    // 服务启动
    protected function boot()
    {

    }
}