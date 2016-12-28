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
     * @param string $tableName
     * @return string
     */
    private function tableNameQuery(string $tableName): string
    {
        return 'SELECT name
                FROM sqlite_master
                WHERE type="table"
                AND name="' . $tableName . '"';
    }

    /**
     * @var string
     *      Gets the table information
     */
    const SCHEMA_QUERY_TABLE_PRAGMA = 'PRAGMA table_info(:name)';

    private function columnNameQuery($tableName)
    {
        return 'PRAGMA table_info(' . $tableName . ')';
    }

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
        $statement = $this->pdo->query($this->tableNameQuery($tableName))
                               ->fetch();

        return (!$statement) ? false : true;
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
        $rows = $this->pdo->query($this->columnNameQuery($tableName))
                          ->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return false;
        }

        foreach ($rows as $row) {
            if ($row['name'] === $columnName) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $tableName
     *      The name of the table to get the columns from
     * @return array
     *      An array of string, each column name
     */
    public function getColumnNames(string $tableName): array
    {
        $rows = $this->pdo->query($this->columnNameQuery($tableName))
                          ->fetchAll();

        $cols = [];

        foreach ($rows as $row) {
            $cols[] = $row['name'];
        }

        return $cols;
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

            $buffer .= "); ";
        }

        return $buffer;
    }
}
