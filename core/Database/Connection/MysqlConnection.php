<?php

namespace Core\Database\Connection;

use Core\Database\Query\MysqlGrammar;
use Core\Database\Query\QueryBuilder;
use PDOException;

class MysqlConnection extends Connection
{
    // 调用不存在的方法 调用一个新的查询构造器
    public function __call($method, $parameters)
    {
        return $this->newBuilder()->{$method}(...$parameters);
    }

    public function select($query, $bindings = [], $useReadPdo = true)
    {
        $sth = $this->pdo->prepare($query);

        try {
            $sth->execute($bindings);

            return $sth->fetchAll();
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
    }

    // 创建新的查询器
    public function newBuilder(): QueryBuilder
    {
        return new QueryBuilder($this, new MysqlGrammar());
    }
}
