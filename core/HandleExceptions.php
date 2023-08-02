<?php

namespace Core;

use Throwable;

class HandleExceptions
{
    // 要忽略记录的异常 不记录到日志去
    protected array $ignore = [
    ];

    public function init(): void
    {
        // 所有错误到托管到handleError方法
        // trigger_error("This is a custom error", E_USER_ERROR);
        set_error_handler([$this, 'handleError']);

        // 所有异常到托管到handleException方法
        set_exception_handler([$this, 'handleException']);
    }

    /**
     * 将PHP错误转换为ErrorException实例.
     */
    public function handleError(int $severity, string $message, string $file, int $line): void
    {
        app('response')->setContent('服务器错误')->setCode(500)->send();

        app('log')->error($message . ' => ' . $line . ':' . $file);
    }

    public function handleException(Throwable $exception): void
    {
        if (method_exists($exception, 'render')) { // 如果自定义的异常类存在render()方法
            app('response')->setContent($exception->render())->send();
        }

        if (!$this->isIgnore($exception)) { // 不忽略 记录异常到日志去
            app('log')->debug($exception->getMessage() . ' at ' . $exception->getFile() . ':' . $exception->getLine());

            // 显示给开发者看 以便查找错误
            echo $exception->getMessage() . ' at ' . $exception->getFile() . ':' . $exception->getLine();
        }
    }

    // 是否忽略异常
    protected function isIgnore(Throwable $e): bool
    {
        return (bool) in_array(get_class($e), $this->ignore);
    }
}
