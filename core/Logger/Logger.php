<?php

namespace Core\Logger;

use App;

class Logger
{
    protected array $channels = [];

    protected $config;

    public function __construct()
    {
        $this->config = App::getContainer()->get('config')->get('log');
    }

    public function __call($method, $parameters)
    {
        return $this->channel()->{$method}(...$parameters);
    }

    public function channel($name = null)
    {
        if (!$name) {
            $name = $this->config['default'];
        }

        if (isset($this->channels[$name])) {
            return $this->channels[$name];
        }

        $config = App::getContainer()->get('config')->get('log.channels.' . $name);

        // 如:$config['driver'] = stack, 则调用createStack($config);
        return $this->channels['name'] = $this->{'create' . ucfirst($config['driver'])}($config);
    }

    public function createStack($config): StackLogger
    {
        return new StackLogger($config);
    }

    public function createDaily($config): DailyLogger
    {
        return new DailyLogger($config);
    }
}
