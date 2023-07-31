<?php

namespace Core;

use PDO;

abstract class Connection
{
    protected string $tablePrefix;

    public function __construct(
        protected PDO $pdo,
        protected array $config
    ) {
        $this->tablePrefix = $config['prefix'];
    }
}
