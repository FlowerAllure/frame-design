<?php

namespace Core;

class QueryBuilder
{
    public string $from;

    public array $binds;

    public array $columns;

    public bool $distinct = false;

    public array $wheres;

    public array $bindings = [
        'select' => [],
        'from' => [],
        'join' => [],
        'where' => [],
        'groupBy' => [],
        'having' => [],
        'order' => [],
        'union' => [],
        'unionOrder' => [],
    ];

    protected array $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>', 'like', 'like binary', 'not like', 'ilike', '&', '|', '^',
        '<<', '>>', 'rlike', 'not rlike', 'regexp', 'not regexp', '~', '~*', '!~', '!~*', 'similar to', 'not similar to',
        'not ilike', '~~*', '!~~*',
    ];

    public function __construct(protected Connection $connection, protected SqlGrammar $grammar)
    {
    }

    public function table(string $table, $as = null): static
    {
        return $this->from($table, $as);
    }

    public function from($table, $as): static
    {
        $this->from = $as ? "{$table} as {$as}" : $table;

        return $this;
    }

    public function get($columns = ['*']): array|null|false
    {
        $this->columns = is_array($columns) ? $columns : func_get_args();
        $sql = $this->toSql();

        return $this->runSql($sql);
    }

    public function toSql(): string // 编译成SQL
    {
        return $this->grammar->compileSql($this);
    }

    public function runSql($sql): false|array|null // 运行sql
    {
        return $this->connection->select($sql, $this->getBinds());
    }

    public function where($column, $operator = null, $value = null, $joiner = 'and'): static
    {
        // where(['id' => '2','name' => 'xxx'])
        if (is_array($column)) {
            foreach ($column as $col => $value) {
                $this->where($col, '=', $value);
            }
        }
        // where('name', 'xxx')
        if (!in_array($operator, $this->operators)) {
            $value = $operator;
            $operator = '=';
        }
        // where('name', '=', 1)
        $this->wheres[] = compact(
            'column',
            'operator',
            'value',
            'joiner'
        );
        $this->binds[] = $value;

        return $this;
    }

    public function orWhere($column, $operator = null, $value = null): static
    {
        return $this->where($column, $operator, $value, 'or');
    }

    public function find($id, $columns = ['*'], $key = 'id'): false|array|null
    {
        return $this->where($key, $id)->get($columns);
    }

    public function getBinds(): array
    {
        return $this->binds;
    }
}
