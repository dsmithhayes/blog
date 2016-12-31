#!/usr/bin/env php
<?php

$app = require_once __DIR__ . '/../bootstrap.php';
$container = $app->getContainer();

$posts_dir = $container->settings['posts']['path'];

if (!($files = scandir($posts_dir))) {
    die("Unable to read directory: {$posts_dir}");
}

foreach ($files as $file) {
    if ($file === '.' || $file === '..') {
        continue;
    }

    $post = $container->posts->findBy('filename', $file);

    /**
     * Post doesn't exist already
     */
    if (!$post) {

    }
}

return 0;
