<?php

namespace App\Exceptions;

class HandleExceptions extends \Core\HandleExceptions
{
    // 要忽略记录的异常 不记录到日志去
    protected array $ignore = [
        ErrorMessageException::class,
    ];
}
