<?php

require_once 'vendor/autoload.php';

use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use PHPMailer;
use Blog\Lib\Database\Model;

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

// Debugging
$settings['settings']['displayErrorDetails'] = true;

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
 * Add the Markdown parser.
 */
$container['markdown'] = function ($container) {
    return new Parsedown();
};

/**
 * Primary PDO instance
 */
$container['pdo'] = function ($container) {
    $pdo = new PDO($container->settings['database']['dsn']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
};

/**
 * Posts model
 */
$container['posts'] = function ($container) {
    return new Model('posts', $container->pdo);
};

/**
 * The PHPMailer object
 */
$container['mailer'] = function ($container) {
    $mailer = new PHPMailer();

    $mailer->isSMTP();

    $mailer->Host     = $container->settings['email']['smtp']['host'];
    $mailer->SMTPAuth = true;
    $mailer->Secure   = 'tls';
    $mailer->Username = $container->settings['email']['smtp']['username'];
    $mailer->Password = $container->settings['email']['smtp']['password'];
    $mailer->Port     = $container->settings['email']['smtp']['post'];

    return $mailer;
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
