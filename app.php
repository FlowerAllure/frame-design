<?php

use App\Middleware\WebMiddleWare;
use Core\Config;
use Core\Database\Database;
use Core\IOC;
use Core\PipeLine;
use Core\Response;
use Core\Router;
use Core\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

const FRAME_BASE_PATH = __DIR__; // 框架目录
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

    public function get(string $id): mixed
    {
        return $this->has($id) ? $this->instances[$id] : $this->make($id);
    }

    public function has(string $id): bool
    {
        return isset($this->instances[$id]);
    }

    public static function getContainer(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    // 注册绑定
    protected function register(): void
    {
        $registers = [
            'response' => Response::class,
            'router' => Router::class,
            'pipeLine' => PipeLine::class,
            'config' => Config::class,
            'db' => Database::class,
            'view' => View::class,
        ];
        foreach ($registers as $name => $register) {
            $this->bind($name, $register, true);
        }
    }

    // 服务启动

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function boot(): void
    {
        self::getContainer()->get('config')->init();
        self::getContainer()->get('view')->init();
        self::getContainer()->get('router')->group([
            'namespace' => 'App\\Controller',
            'middleware' => [
                WebMiddleWare::class,
            ],
        ], function ($router) {
            require_once FRAME_BASE_PATH . '/routes/web.php';
        });

        self::getContainer()->get('router')->group([
            'namespace' => 'App\\Controller',
            'prefix' => 'api',
        ], function ($router) {
            require_once FRAME_BASE_PATH . '/routes/api.php';
        });
    }
}
