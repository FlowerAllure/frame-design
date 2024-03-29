<?php

function hello(): string
{
    return 'world';
}

if (!function_exists('response')) {
    function response()
    {
        return App::getContainer()->get('response');
    }
}

function app($name = null)
{
    if ($name) { // 如果选择了具体实例
        return App::getContainer()->get($name);
    }

    return App::getContainer();
}

function endView(): void
{
    $time = microtime(true) - FRAME_START_TIME;
    $memory = memory_get_usage() - FRAME_START_MEMORY;

    echo '<hr/>运行时间: ' . round($time * 1000, 2) . 'ms';
    echo '<br/>消耗内存: ' . round($memory / 1024 / 1024, 2) . 'm';
}

function config($key = null)
{
    if ($key) {
        return App::getContainer()->get('config')->get($key);
    }

    return App::getContainer()->get('config');
}
