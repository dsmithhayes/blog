<?php

$app = require_once __DIR__ . '/../bootstrap.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Routes for the application
 */
$app->get('/[home]', function (Request $req, Response $res) {
    return $this->view->render($res, 'home.twig', [
        'title' => 'Home'
    ]);
});

/**
 * Send the response to the client.
 */
$app->run();
