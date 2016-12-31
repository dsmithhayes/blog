<?php

namespace Blog\Lib\Database;

use PDO;
use PDOException;
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
        return $this->get((string) $key);
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
        $this->set((string) $key, $value);
    }

    /**
     * @param int $id
     *      The primary key of the row to represent the data from
     */
    public function find(int $id)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = {$id}";
        $row = $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

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
        if (is_string($value)) {
            $value = "\"{$value}\"";
        }

        $sql = "SELECT * FROM {$this->tableName} WHERE {$columnName} = {$value}";

        try {
            $row = $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return false;
            }

            foreach ($row as $name => $value) {
                $this->columns[$name] = $value;
            }
        } catch (PDOException $pe) {
            $message = "PDO Error: " . $pe->getMessage();
            $message .= "\nQuery: {$sql}\n";
            throw new DatabaseException($message);
        }

        $this->dirty = false;
        return $this;
    }

    /**
     * When there are no entries in the database, the method will return
     * an empty array.
     *
     * @return array
     *      An array of Model objects fully hydrated with their row data.
     */
    public function findAll(): array
    {
        $sql = "SELECT *
                FROM {$this->tableName}";

        $rows = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        $models = [];

        foreach ($rows as $row) {
            $models[$row['id']] = clone $this;
            $models[$row['id']]->find($row['id']);
        }

        return $models;
    }

    /**
     * Persists the data into the database
     */
    public function save()
    {
        // Insert if the model is dirty
        if ($this->dirty) {

            // if the ID is present, it already exists and update the record
            if ($this->columns['id']) {

            // If the ID is not present, insert a new record
            } else {

            }
        }
    }

    /**
     * @param string $key
     *      The name of the column
     * @param mixed $value
     *      The value to set
     */
    public function set(string $key, $value)
    {
        if (!array_key_exists($key, $this->columns)) {
            throw new DatabaseException('Unknown colum name: ' . $key);
        }

        $this->columns[$key] = $value;
        $this->dirty = true;

        return $this;
    }

    /**
     * @param string $key
     *      The name of the column
     * @return mixed
     *      The data in the column
     */
    public function get($key)
    {
        return $this->columns[$key];
    }
}
