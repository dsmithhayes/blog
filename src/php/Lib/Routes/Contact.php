<?php

namespace Blog\Lib\Routes;

use Interop\Container\ContainerInterface as Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Blog\Lib\Route;
use Blog\Lib\Email\{Headers, Handler};

class Contact
{
    /**
     * The route callback for loading the form
     *
     * @param Interop\Container\ContainerInteface $container
     * @return Blog\Lib\Route
     */
    public function index(Container $container): Route
    {
        return new class($container) extends Route {
            public function __construct($container)
            {
                $this->setContainer($container);

                $this->setName('load-contact')
                     ->setMethod('get')
                     ->setRoute('/contact')
                     ->setCallback(function (Request $req, Response $res) {
                         return $this->view->render($res, 'contact.twig', [
                             'title' => 'Contact'
                         ]);
                     });
            }
        };
    }

    public function handleForm(Container $container): Route
    {
        return new class($container) extends Route {
            public function __construct($container)
            {
                $this->setContainer($container);

                $this->setName('handle-contact')
                     ->setMethod('post')
                     ->setRoute('/contact')
                     ->setCallback(function (Request $req, Response $res) {
                         // handle the form here
                         $name = $req->getParam('name');
                         $email = $req->getParam('email');
                         $subject = "Hello from {$name}!";
                         $message = $req->getParam('message');

                         $headers = new Headers();
                         $headers->addHeader('From', "{$name} <{$email}>");

                         $handler = new Handler($subject, $message, $headers);

                         if (!$handler->send()) {
                             return $res->withStatus(500);
                         }

                         return $this->view->render($res, 'contact.twig', [
                             'title' => 'Contact'
                         ]);
                     });
            }
        };
    }
}
