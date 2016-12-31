#!/usr/bin/env php
<?php

use Blog\Lib\Database\Schema;

/**
 * Get the application container
 */
$app = require_once __DIR__ . '/../bootstrap.php';
$container = $app->getContainer();

/**
 * Build a Schema instance
 */
$schema = new Schema($container->pdo);

/**
 * Check the table definitions against the tables in the database. If the table
 * doesn't exist, create it.
 */
foreach ($container->settings['database']['tables'] as $tableName => $columns) {
    if (!$schema->tableExists($tableName)) {
        if ($schema->buildTables([$tableName => $columns]) === false) {
            die("Error building table: {$tableName}");
        }
    }
}

/**
 * No news is good news.
 */
return 0;
