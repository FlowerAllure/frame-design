<?php

namespace Core\Database\Model;

class Builder
{
    protected Model $model;

    public function __construct(protected $query)
    {
    }

    public function __call($method, $args)
    {
        $this->query->{$method}(...$args);

        return $this;
    }

    public function setModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function get($columns = ['*']): array
    {
        if (!is_array($columns)) {
            $columns = func_get_args();
        }

        $this->query->columns = $columns;
        $this->query->table($this->model->getTable());
        $sql = $this->query->toSql();

        return $this->bindModel(
            $this->query->runSql($sql)
        );
    }

    // 数据映射模式 把数据映射到模型
    // 模型的本质: 每条数据都是一个模型(对象)
    protected function bindModel($data): array
    {
        $data = is_array($data) ? $data : [$data];

        $models = [];
        foreach ($data as $datum) { // 多少条数据就多少个模型
            $model = clone $this->model; // 原型模式
            foreach ($datum as $key => $val) {
                $model->setOriginalValue($key, $val);
            }
            $model->syncOriginal(); // 把 attributes = original
            $models[] = $model;
        }

        return $models;
    }
}
