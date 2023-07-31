<?php

namespace Core;

class Config
{
    protected array $config = [];

    public function init(): void
    {
        foreach (glob(FRAME_BASE_PATH . '/config/*.php') as $file) {
            $key = str_replace('.php', '', basename($file));
            $this->config[$key] = require $file;
        }
    }

    // 获取配置
    public function get($key)
    {
        $keys = explode('.', $key);
        $config = $this->config;

        foreach ($keys as $key) {
            $config = $config[$key];
        }

        return $config;
    }

    // 重置配置的值
    public function set($key, $val): void
    {
        $keys = explode('.', $key);

        $config = &$this->config;
        foreach ($keys as $key) {
            $config = &$config[$key];
        }

        $config = $val;
    }
}
