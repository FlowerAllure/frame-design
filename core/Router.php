<?php

namespace Core;

use App;
use Closure;
use Psr\Http\Message\RequestInterface;

class Router
{
    public array $currentGroup = []; // 当前组

    protected array $routes = []; // 所有路由存放

    protected string $route_index = ''; // 当前访问的路由

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function group(array $attributes, Closure $callback): void
    {
        $this->currentGroup[] = $attributes; // 可能存着多个 group, 如 group()->group()->...
        call_user_func($callback, $this); // $callback($this);
        array_pop($this->currentGroup);
    }

    // 增加路由
    public function addRoute($method, $uri, $uses): static
    {
        [$prefix, $middleware, $namespace] = $this->parseGroup();
        $this->addSlash($uri);
        $method = strtoupper($method); // 请求方式 转大写
        $uri = $prefix . $uri; // 路由
        $this->route_index = $method . $uri;
        $this->routes[$this->route_index] = [
            'method' => $method,
            'uri' => $uri,
            'action' => [
                'uses' => $uses,
                'middleware' => $middleware,
                'namespace' => $namespace,
            ],
        ];

        return $this;
    }

    public function middleware($class): static
    {
        $this->routes[$this->route_index]['action']['middleware'][] = $class;

        return $this;
    }

    public function get($uri, $uses): static
    {
        return $this->addRoute('get', $uri, $uses);
    }

    public function post($uri, $uses): static
    {
        return $this->addRoute('post', $uri, $uses);
    }

    public function put($uri, $uses): static
    {
        return $this->addRoute('put', $uri, $uses);
    }

    public function delete($uri, $uses): static
    {
        return $this->addRoute('delete', $uri, $uses);
    }

    // 更具request执行路由
    public function dispatch(RequestInterface $request)
    {
        $method = $request->getMethod();
        $uri = $request->getUri();
        $this->route_index = $method . $uri;

        $route = $this->getCurrentRouter();
        if (!$route) {
            return 404;
        }

        $routerDispatch = $route['action']['uses'];
        $middleware = $route['action']['middleware'] ?? [];

        // return $routerDispatch();
        $routerClosure = App::getContainer()->get('pipeLine')->create()->setClass($middleware)->run($routerDispatch);

        return call_user_func($routerClosure, $request);
    }

    // 增加 / 如: USER 改成 /USER
    protected function addSlash(&$uri): bool|string
    {
        return '/' == $uri[0] ?: $uri = '/' . $uri;
    }

    protected function getCurrentRouter()
    {
        $routes = $this->getRoutes();
        if (isset($routes[$this->route_index])) {
            return $routes[$this->route_index];
        }
        $this->route_index .= '/';
        if (isset($routes[$this->route_index])) {
            return $routes[$this->route_index];
        }

        return false;
    }

    // 解析路由组; 获取前缀, 中间接, 和命名空间
    private function parseGroup(): array
    {
        $prefix = ''; // 前缀
        $middleware = []; // 中间件
        $namespace = ''; // 命名空间
        foreach ($this->currentGroup as $group) {
            $prefix .= $group['prefix'] ?? false;
            if ($prefix) {
                $this->addSlash($prefix);
            }
            $middleware = $group['middleware'] ?? [];
            $namespace .= $group['namespace'] ?? '';
        }

        return [$prefix, $middleware, $namespace];
    }
}
