<?php

use App\Utils\App;
use App\Utils\IOC;

require __DIR__ . '/../vendor/autoload.php';

interface Log
{
    public function write();
}

// 文件记录日志
class FileLog implements Log
{
    public function write()
    {
        echo 'file log write...';
    }
}

// 数据库记录日志
class DatabaseLog implements Log
{
    public function write()
    {
        echo 'database log write...';
    }
}

class User
{
    protected $log;

    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function login()
    {
        // 登录成功，记录登录日志
        echo 'login success...';
        $this->log->write();
    }
}

// 实例化IoC容器
$ioc = new IOC();
$ioc->bind('Log', 'DatabaseLog');
$ioc->bind('User', 'User');
$user = $ioc->make('User');
$user->login();

App::getContainer()->bind('Log', 'DatabaseLog');
App::getContainer()->bind('User', 'User');

$user = App::getContainer()->get('User');
$user->login();
