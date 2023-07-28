<?php

namespace App\Utils;

use ReflectionClass;
use ReflectionParameter;

class IOC
{
    public array $binding = [];

    public function bind(string $abstract, mixed $concrete): void
    {
        $this->binding[$abstract]['concrete'] = fn($ioc) => $ioc->build($concrete);
    }

    public function make($abstract)
    {
        $concrete = $this->binding[$abstract]['concrete'];
        return $concrete($this);
    }

    public function build($concrete): ?object
    {
        $reflector= new ReflectionClass($concrete);
        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return $reflector->newInstance();
        }
        $dependencies = $constructor->getParameters();
        $args = $this->getDependencies($dependencies);
        return $reflector->newInstanceArgs($args);
    }

    /**
     * @param ReflectionParameter [] $parameters
     */
    protected function getDependencies(array $parameters): array
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $dependencies[] = $this->make($parameter->getType()->getName());
        }

        return $dependencies;
    }
}