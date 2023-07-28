<?php

namespace Core;

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

trait IOC
{
    public array $binding = []; // 绑定关系

    protected array $instances = []; // 所有实例的存放

    public function bind(string $id, mixed $concrete, bool $is_singleton = false): void
    {
        if (! $concrete instanceof \Closure) {
            $concrete = function ($app) use ($concrete) {
                return $app->build($concrete);
            };
        }

        $this->binding[$id] = compact('concrete', 'is_singleton');
    }

    /**
     * @param mixed $concrete
     * @return object|null
     * @throws ReflectionException
     */
    public function build(mixed $concrete): ?object
    {
        $reflector = new ReflectionClass($concrete); // 反射
        $constructor = $reflector->getConstructor(); // 获取构造函数
        if( is_null($constructor))
            return $reflector->newInstance(); // 没有构造函数？那就是没有依赖 直接返回实例
        $dependencies = $constructor->getParameters(); // 获取构造函数的参数
        $instances = $this->getDependencies($dependencies);  // 当前类的所有实例化的依赖
        return $reflector->newInstanceArgs($instances); // 跟new 类($instances); 一样了
    }


    /**
     * @param ReflectionParameter[] $parameters
     * @return array
     */
    protected function getDependencies(array $parameters): array
    {
        $dependencies = []; // 当前类的所有依赖
        foreach ($parameters as $parameter)
            if ($parameter->getType()) {
                $dependencies[] = $this->make($parameter->getType()->getName());
            }
        return $dependencies;
    }

    public function make($abstract)
    {
        $instance = $this->binding[$abstract]['concrete']($this); // 因为服务是闭包 加()就可以执行了
        if ($this->binding[$abstract]['is_singleton']) {
            $this->instances[$abstract] = $instance;
        }

        return $instance;
    }
}