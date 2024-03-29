<?php

namespace Core\Database;

use App;
use Core\Database\Connection\MysqlConnection;
use PDO;
use PDOException;

class Database
{
    protected array $connections = []; // all connection

    // 代理模式
    public function __call($method, $parameters)
    {
        return $this->connection()->{$method}(...$parameters);
    }

    // 设置默认链接
    public function setDefaultConnection($name): void
    {
        App::getContainer()->get('config')->set('database.default', $name);
    }

    // 根据配置信息的name来创建链接
    public function connection(string $name = null)
    {
        if (null == $name) {
            $name = $this->getDefaultConnection();
        }
        if (isset($this->connections[$name])) { // 如果存在就直接返回
            return $this->connections[$name];
        }
        $config = App::getContainer()->get('config')->get('database.connections.' . $name); // 获取链接的配置

        $dsn = sprintf('%s:host=%s;dbname=%s', $config['driver'], $config['host'], $config['dbname']);

        try {
            $pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
        $connectionClass = null; // 链接处理的类
        if ('mysql' == $config['driver']) {  // 如果有其他类型的数据库 那就继续完善
            $connectionClass = MysqlConnection::class;
        }

        return $this->connections[$name] = new $connectionClass($pdo, $config);
    }

    // 获取默认链接
    protected function getDefaultConnection()
    {
        return App::getContainer()->get('config')->get('database.default');
    }
}
