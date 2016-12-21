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
    new class($container) extends Route {
        private $templateFile = 'contact.twig';

        public function __construct($container)
        {
            $this->setContainer($container);
            $this->setName('contact')
                 ->setMethod('get')
                 ->setRoute('/contact')
                 ->setCallback(self::class . ':contact');
        }

        public function contact(Request $req, Response $res)
        {
            return $this->container->view->render($res, $this->templateFile, [
                'title' => 'Contact'
            ]);
        }
    },

    /**
     * Handles the submittion of the contact form
     */
    new class($container) extends Route {
        public function __construct($container)
        {
            $this->setContainer($container);
            $this->setName('contact-submit')
                 ->setMethod('post')
                 ->setRoute('/contact')
                 ->setCallback(self::class . ':handleForm');
        }

        public function handleForm(Request $req, Response $res): Response
        {

            return $res;
        }
    }
]);
