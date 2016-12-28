<?php

namespace Blog\Lib\Database;

use Extended\LinkedList;
use PDO;
use Blog\Lib\Exception\DatabaseException;

class Schema
{
    /**
     * @var string
     *      The string that queries the database for all the table names
     */
    const SCHEMA_QUERY_TABLE_NAME = 'SELECT name
                                     FROM sqlite_master
                                     WHERE type="table"
                                     AND name=:name';

    /**
     * @var string
     *      Gets the table information
     */
    const SCHEMA_QUERY_TABLE_PRAGMA = 'PRAGMA table_info(:name)';

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
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * @param string $tableName
     *      The name of the table
     * @return bool
     *      True if the table exists
     */
    public function tableExists(string $tableName): bool
    {
        $statement = $this->pdo->prepare(self::SCHEMA_QUERY_TABLE_NAME)
                               ->execute(['name' => $tableName]);

        if (!$statement->fetchAll()) {
            return false;
        }

        return true;
    }

    /**
     * @param string $tableName
     *      The name of the table to check
     * @param string $columnName
     *      The name of the column to check
     * @return bool
     *      True if the column exists in the table
     */
    public function columnExists(string $tableName, string $columnName): bool
    {
        $statement = $this->pdo->prepare(self::SCHEMA_QUERY_TABLE_PRAGMA)
                               ->execute(['name' => $tableName]);

        foreach ($statement->fetchAll() as $row) {
            if ($row['name'] === $columName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Builds all of the tables. The table schema is a basic array which
     *
     * @return string
     *      The query string to create the tables
     */
    public function buildQueryString($tables): string
    {
        $buffer = '';

        foreach ($tables as $tableName => $columns) {
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
}
