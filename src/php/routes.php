<?php

/**
 * This file defines all of the routes for the application.
 */

use Blog\Lib\Route;
use Blog\Lib\Router;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return new Router([

    /**
     * The Home route.
     */
    new class extends Route {
        public function __construct()
        {
            $this->setName('home')
                 ->setMethod('get')
                 ->setRoute('/[home]')
                 ->setCallback(function (Request $req, Response $res) {

                    return $res;
                 });
        }
    },

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
    }
]);
