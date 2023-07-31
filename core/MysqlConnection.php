<?php

namespace Core;

use PDOException;

class MysqlConnection extends Connection
{
    // 调用不存在的方法 调用一个新的查询构造器
    public function __call($method, $parameters)
    {
        // 返回QueryBuilder类
        return $this->newBuilder()->{$method}(...$parameters);
    }

    public function select($sql, $bindings = [], $useReadPdo = true)
    {
        $statement = $this->pdo;
        $sth = $statement->prepare($sql);

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
