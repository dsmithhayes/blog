#!/usr/bin/env php
<?php

use Blog\Lib\Exception\DatabaseException;

$app = require_once __DIR__ . '/../bootstrap.php';
$container = $app->getContainer();

$posts_dir = $container->settings['posts']['path'];

if (!($files = scandir($posts_dir))) {
    die("Unable to read directory: {$posts_dir}");
}

$file_count = 0;

foreach ($files as $file) {
    if ($file === '.' || $file === '..') {
        continue;
    }

    $file_count++;

    try {
        $post = $container->posts->findBy('filename', $file);

        if (!$post) {
            die('No post found.');
        }
    } catch (DatabaseException $de) {
        die("{$de->getMessage()}\n");
    }
}

if ($file_count === 0) {
    die("No posts found.\n");
}

return 0;
