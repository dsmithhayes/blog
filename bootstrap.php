<?php

require_once 'vendor/autoload.php';

use Slim\Views\Twig;
use Slim\Views\TwigExtension;

/**
 * Initialize the application, break out the container.
 */
$app = new Slim\App();
$container = $app->getContainer();

/**
 * Read all of the configuration.
 */
$container['config'] = function ($container) {
    $tmp = [];

    foreach (scandir(__DIR__ . '/config') as $conf) {
        if ($conf === '.' || $conf === '..') {
            continue;
        }

        $key = preg_replace('/\.php/', '', $conf);
        $tmp[$key] = require __DIR__ . '/config/' . $conf;
    }

    if (empty($tmp)) {
        $tmp = ['error' => 'No configuration files loaded.'];
    } else {
        $tmp['error'] = null;
    }

    return $tmp;
};

/**
 * Initialize the Templates
 */
$container['view'] = function ($container) {
    $path = $container->config['views']['path'];
    $cache = $container->config['views']['cache'];

    $view = new Twig($path);

    $view->addExtension(new TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};

/**
 * Send the application to the response.
 */
return $app;
