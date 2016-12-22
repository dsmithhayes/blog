<?php

/**
 * This file defines all of the routes for the application.
 */

use Blog\Lib\{Route, Router};
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Blog\Lib\Routes\{Home, Contact, Blog, Post};

$container = $app->getContainer();

return new Router([
    // Home page
    (new Home())->index($container),

    // Contact page
    (new Contact())->index($container),
    (new Contact())->handleForm($container),

    /**
     * The Blog home route.
     */
    new class extends Route {
        public function __construct()
        {
            $this->setName('blog-home')
                 ->setMethod('get')
                 ->setRoute('/blog')
                 ->setCallback(function (Request $req, Response $res) {

                     return $res;
                 });
        }
    },
]);
