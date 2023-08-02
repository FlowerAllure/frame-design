<?php

namespace Core\Logger;

use Psr\Log\AbstractLogger;
use Stringable;

class DailyLogger extends AbstractLogger
{
    public function __construct(protected array $config)
    {
    }

    public function log($level, Stringable|string $message, array $context = []): void
    {
        $message = sprintf($this->config['format'], date('Y-m-d H:i:s'), $level, $this->interpolate($message, $context));

        error_log($message . PHP_EOL, 3, $this->config['path'] . '/daily-' . date('Y-m-d') . ' .log');
    }

    public function interpolate(string $message, array $context = []): string
    {
        $replace = [];
        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        return strtr($message, $replace);
    }
}
