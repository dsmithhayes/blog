<?php

namespace Blog\Lib\Database;

use PDO;
use Blog\Lib\Exception\DatabaseException;

class Model
{
    private $pdo;
    private $tableName;
    private $columns;

    public function __construct(string $tableName, PDO $pdo)
    {

    }

    public function __get($key)
    {
        return $this->columns[$key];
    }

    public function __set($key, $value)
    {
        if (!in_array($key, $this->columns)) {
            throw new DatabaseException('Unknown colum name: ' . $key);
        }

        $this->columns[$key] = $value;
    }
}
