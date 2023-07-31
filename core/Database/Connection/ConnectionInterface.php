<?php

namespace Core\Database\Connection;

interface ConnectionInterface
{
    public function select($query, $bindings = [], $useReadPdo = true);

    public function insert($query, $bindings = []);

    public function update($query, $bindings = []);

    public function delete($query, $bindings = []);

    public function statement($query, $bindings = []);

    public function prepareBindings(array $bindings);

    public function beginTransaction();

    public function commit();

    public function rollBack();
}
