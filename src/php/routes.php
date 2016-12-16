<?php

/**
 * This file defines all of the routes for the application.
 */

use Blog\Lib\Route;
use Blog\Lib\Router;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

if ($app) {
    $container = $app->getContainer();
}

return new Router([

    /**
     * The Home route.
     */
    new class($container) extends Route {
        public function __construct($container)
        {
            $this->setContainer($container);

            $this->setName('home')
                 ->setMethod('get')
                 ->setRoute('/[home]')
                 ->setCallback(function (Request $req, Response $res) {
                    return $this->view->render($res, 'home.twig', [
                        'title' => 'Home'
                    ]);
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
    },

    new class extends Route {
        public function __construct()
        {
            $this->setName('test')
                 ->setMethod(['get', 'post'])
                 ->setRoute('/test')
                 ->setCallback(function (Request $req, Response $res) {
                     $res->getBody()->write('It works!');
                     return $res;
                 });
        }
    }
]);
