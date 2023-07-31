<?php

namespace Core;

use Closure;

class PipeLine
{
    // 所有要执行的类
    protected array $classes = [];

    // 类的方法名称
    protected string $handleMethod = 'handle';

    public function setHandleMethod($method): static
    {
        $this->handleMethod = $method;

        return $this;
    }

    public function setClass($class): static
    {
        $this->classes = $class;

        return $this;
    }

    // 因为容器的单例的,所以要创建一个新的 对象
    public function create(): self|static
    {
        return clone $this;
    }

    public function run(Closure $initial): Closure
    {
        return array_reduce(array_reverse($this->classes), function ($res, $currentClass) {
            return function ($request) use ($res, $currentClass) {
                return (new $currentClass())->{$this->handleMethod}($request, $res);
            };
        }, $initial);
    }
}
