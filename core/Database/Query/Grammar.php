<?php

namespace Core\Database\Query;

abstract class Grammar
{
    protected array $selectComponents = [
        'columns',
        'from',
        'joins',
        'wheres',
        'groups',
        'havings',
        'orders',
        'limit',
        'offset',
        'lock',
    ];

    public function compileSql(QueryBuilder $query): string
    {
        $sql = [];
        foreach ($this->selectComponents as $component) {
            if (isset($query->{$component})) {
                $sql[$component] = $this->{$component}($query, $query->{$component});
            }
        }

        return implode($sql);
    }

    protected function columns(QueryBuilder $query, $columns): string
    {
        if (!$columns) {
            $columns = ['*'];
        }
        $select = 'select ';
        if ($query->distinct) {
            $select = 'select distinct ';
        }

        return $select . implode(',', $columns);
    }

    protected function from(QueryBuilder $builder, $form): string
    {
        return ' from ' . $form;
    }

    protected function wheres(QueryBuilder $builder, $wheres): string
    {
        if (!$wheres) {
            return '';
        }
        $where_arr = [];
        foreach ($wheres as $index => $where) {
            if (!$index) {
                $where['joiner'] = ' where';
            }
            $where_arr[] = sprintf(' %s `%s` %s ?', $where['joiner'], $where['column'], $where['operator']);
        }

        return implode($where_arr);
    }
}
