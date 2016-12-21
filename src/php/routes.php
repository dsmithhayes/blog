<?php

/**
 * This file defines all of the routes for the application.
 */

use Blog\Lib\Route;
use Blog\Lib\Router;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$container = $app->getContainer();

return new Router([

    /**
     * The Home route.
     */
    new class($container) extends Route {
        /**
         * @var string
         *      The name of the template file for this route's response
         */
        private $templateFile = 'home.twig';

        public function __construct($container)
        {
            $this->setContainer($container);

            // Do something with the container to prepare for the callback

            $this->setName('home')
                 ->setMethod('get')
                 ->setRoute('/[home]')
                 ->setCallback(self::class . ':about');
        }

        /**
         * Gets the about markdown file and renders it to the view.
         */
        public function about(Request $req, Response $res)
        {
            return $this->container->view->render($res, $this->templateFile, [
                'title' => 'Home'
            ]);
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

    /**
     * Defines the contact form route
     */
    new class extends Route {
        public function __construct()
        {
            $this->setName('contact')
                 ->setMethod('get')
                 ->setRoute('/contact')
                 ->setCallback(function (Request $req, Response $res) {

                     return $res;
                 });
        }
    },

    /**
     * Handles the submittion of the contact form
     */
    new class extends Route {
        public function __construct()
        {
            $this->setName('contact-submit')
                 ->setMethod('post')
                 ->setRoute('/contact')
                 ->setCallback(function (Request $req, Response $res) {

                     return $res;
                 });
        }
    }

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
