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

$app->get('/blog', function (Request $req, Response $res) {

});

$app->get('/blog/{slug}', function (Request $req, Response $res) {
    $slug = $req->getAttribute('slug');
});

$app->get('/contact', function (Request $req, Response $res) {

});

/**
 * Send the response to the client.
 */
$app->run();
