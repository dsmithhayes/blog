<?php

require_once 'vendor/autoload.php';

use Slim\Views\Twig;
use Slim\Views\TwigExtension;

/**
 * Initialize the application, break out the container.
 */

$settings = [];

foreach (scandir(__DIR__ . '/config') as $conf) {
    if ($conf === '.' || $conf === '..') {
        continue;
    }

    $key = preg_replace('/\.php/', '', $conf);
    $settings['settings'][$key] = require __DIR__ . '/config/' . $conf;
}

$app = new Slim\App($settings);
$container = $app->getContainer();

/**
 * Initialize the Templates
 */
$container['view'] = function ($container) {
    $path = $container->settings['views']['path'];
    $cache = $container->settings['views']['cache'];

    $view = new Twig($path);

    $view->addExtension(new TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};

/**
 * Prepare the routes.
 */
$router = require_once $container->settings['routes']['path'];
$router->hydrate($app);


/**
 * Send the application to the response.
 */
return $app;
