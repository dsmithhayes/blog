<?php

namespace Blog\Lib\Database;

use PDO;
use Blog\Lib\Database\Schema;
use Blog\Lib\Exception\DatabaseException;

class Model
{
    /**
     * @var PDO
     *      Instance of an active PDO
     */
    private $pdo;

    /**
     * @var string
     *      The name of the table for the model
     */
    private $tableName;

    /**
     * @var array
     *      List of all the column names
     */
    private $columns;

    /**
     * @var bool
     *      True if the data in the model has changed from its state in the
     *      database, false if its been unchanged.
     */
    private $dirty;

    /**
     * @var Blog\Lib\Database\Schema
     *      An instance of the table schema
     */
    private $schema;

    /**
     * @param string $tableName
     *      The name of the table to build a model from
     * @param PDO $pdo
     *      The instance of the PDO
     */
    public function __construct(string $tableName, PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->schema = new Schema($this->pdo);

        if (!$this->schema->tableExists($tableName)) {
            throw new DatabaseException("Table '{$tableName}' does not exist.");
        }

        $this->tableName = $tableName;
        $this->columns = $this->schema->getColumnNames($this->tableName);
    }

    /**
     * Allows the Model to have its columns act as public properties.
     *
     * @param string $key
     *      The name of the column
     * @return mixed
     *      The value at the column
     */
    public function __get($key)
    {
        return $this->columns[$key];
    }

    /**
     * Allows the model to set data to the columns as public properties.
     *
     * @param string $key
     *      The name of the column
     * @param mixed $value
     *      The value to update the column to
     */
    public function __set($key, $value)
    {
        if (!in_array($key, $this->columns)) {
            throw new DatabaseException('Unknown colum name: ' . $key);
        }

        $this->columns[$key] = $value;
        $this->dirty = true;
    }

    /**
     * @param int $id
     *      The primary key of the row to represent the data from
     */
    public function find(int $id)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = {$id}";
        $row = $this->pdo->query($sql)
                         ->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return false;
        }

        foreach ($row as $name => $value) {
            $this->columns[$name] = $value;
        }

        $this->dirty = false;
        return $this;
    }

    /**
     * @param string $columnName
     *      The name of the column to find by
     * @param mixed $value
     *      The value to find the model by
     */
    public function findBy(string $columnName, $value)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$columnName} = :value";
        $row = $this->pdo->prepare($sql)
                         ->execute(['value' => $value])
                         ->fetch();

        if (!$row) {
            throw new DatabaseException("PDO error: " . PDO::errorInfo());
        }

        foreach ($row as $name => $value) {
            $this->columns[$name] = $value;
        }

        $this->dirty = false;
        return $this;
    }

    /**
     * @return array
     *      An array of Model objects fully hydrated with their row data.
     */
    public function findAll(): array
    {
        $sql  = "SELECT * FROM {$this->tableName}";
        $rows = $this->pdo->query($sql)
                          ->fetchAll(PDO::FETCH_ASSOC);

        $models = [];

        foreach ($rows as $row) {
            $models[$row['id']] = clone $this;
            $models[$row['id']]->find($row['id']);
        }

        return $models;
    }
}
