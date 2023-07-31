<?php

namespace App\Utils;

class Singleton
{
    private static array $instances = [];

    protected function __construct()
    {
    }

    public function __wakeup(): void
    {
        // TODO: Implement __wakeup() method.
    }

    public static function getInstance(): static
    {
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }

        return self::$instances[$class];
    }
}
