<?php

namespace Blog\Lib\Database;

use Extended\LinkedList;
use PDO;
use Blog\Lib\Exception\DatabaseException;

class Schema
{
    /**
     * @var Extended\LinkedList
     *      A LinkedList of all the tables in the application
     */
    private $tables;

    /**
     * @var PDO
     *      An active PDO instance.
     */
    private $pdo;

    /**
     * @param array $tables
     *      The table schema for the SQLite3 database
     * @param PDO $pdo
     *      An active PDO instance
     */
    public function __construct(array $tables, PDO $pdo)
    {
        $this->tables = new LinkedList($tables);
        $this->pdo = $pdo;

        if (!$this->validSchema()) {
            throw new DatabaseException(
                'Invalid table schema: ' . print_r($schema)
            );
        }
    }

    /**
     * Checks that the loaded schema matches the database
     *
     * @param array|null $schema
     *      A schema to check against, uses the internal one if none given
     * @return bool
     *      True if the table schema is present in the database already
     * @throws Blog\Lib\Exception\DatabaseException
     *      If the schema is invalid
     */
    public function validSchema($schema = null): bool
    {
        if (!$schema) {
            $schema = $this->tables;
        }

        foreach ($schema as $tableName => $columns) {
            $query = 'SELECT name
                      FROM sqlite_master
                      WHERE type="table"
                      AND name=:name';

            $statement = $this->pdo->prepare($query)
                                   ->execute(['name' => $tableName]);

            if (!$statement->fetchAll()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Builds all of the tables
     *
     * @return string
     *      The query string to create the tables
     */
    public function buildQueryString(): string
    {
        $buffer = '';

        foreach ($this->tables as $tableName => $columns) {
            $buffer .= "CREATE TABLE {$tableName} (";

            $i = 0;
            $count = count($columns);

            foreach ($columns as $name => $type) {
                $buffer .= "{$name} {$type}";

                if ($i++ < $count) {
                    $buffer .= ", ";
                }
            }

            $buffer .= "); "
        }

        return $buffer;
    }

    /**
     * @return Extended\LinkedList
     *      The current table schema
     */
    public function getTableSchema(): LinkedList
    {
        return $this->tables;
    }
}
