<?php

namespace Test;

use App;
use Core\Request\PHPRequest;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $response;

    // 代理模式 访问response
    public function __call($name, $arguments)
    {
        return $this->response->{$name}(...$arguments);
    }

    protected function setUp(): void
    {
        require __DIR__ . '/../vendor/autoload.php';

        require_once __DIR__ . '/../app.php';
    }

    protected function tearDown(): void
    {
        $this->assertTrue(true);
    }

    public function call($uri, $method)
    {
        App::getContainer()->bind('request', function () use ($uri, $method) { // 将request绑定到容器
            return PHPRequest::create($uri, $method);
        });

        return $this->response = app('response')->setContent( // 响应
            app('router')->dispatch(App::getContainer()->get('request'))
        );
    }

    public function get($uri, $params = []): static
    {
        $this->call($uri, 'GET', $params);

        return $this;
    }

    public function post($uri, $params = [])
    {
        $this->call($uri, 'POST', $params);

        return $this;
    }

    // 断言状态码是否一样
    protected function assertStatusCode($status): static
    {
        $this->assertEquals($status, $this->response->getStatusCode());

        return $this;
    }
}
