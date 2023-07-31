<?php

namespace Core\Database\Model;

use App;
use stdClass;

class Model
{
    // 绑定的数据库连接
    protected $connection;

    protected string $table = ''; // 表

    protected string $paimaryKey = 'id'; // 主键

    protected bool $timestamps = true; // 是否自动维护时间字段

    protected ?stdClass $original = null;

    protected ?stdClass $attribute = null;

    // 给当前模型绑定一个数据库连接
    public function __construct()
    {
        $this->connection = App::getContainer()->get('db')->connection($this->connection);
    }

    // 见最上面的说明
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    public function __get($name)
    {
        return $this->attribute->{$name};
    }

    // 托管到 __call
    // 因此: User::where() 与 (new User)->where() 是一样的
    public static function __callStatic($method, $args)
    {
        return (new static())->{$method}(...$args);
    }

    public function __call($method, $args)
    {
        return (new Builder(
            $this->connection->newBuilder()
        ))
            ->setModel($this)
            ->{$method}(...$args)
        ;
    }

    // 获取表名称  没有表名称  就返回 模型(小写)+s
    public function getTable(): string
    {
        if ($this->table) {
            return $this->table;
        }

        $class_name = static::class;
        $class_arr = explode('\\', $class_name);

        $table = lcfirst(end($class_arr));

        return $table . 's';
    }

    public function setOriginalValue($key, $val): void
    {
        if (!$this->original) {
            $this->original = new stdClass();
        }
        $this->original->{$key} = $val;
    }

    public function setAttribute($key, $val): void
    {
        if (!$this->attribute) {
            $this->attribute = new stdClass();
        }
        $this->attribute->{$key} = $val;
    }

    public function syncOriginal(): void
    {
        $this->attribute = $this->original;
    }
}
