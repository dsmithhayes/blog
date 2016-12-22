<?php

namespace Blog\Lib\Routes;

use Interop\Container\ContainerInterface as Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Blog\Lib\Route;
use Blog\Lib\Email\Headers;

class Contact
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \Blog\Lib\Email\Headers
     *      Collection of headers for the email that is being sent
     */
    private $headers;

    /**
     * @param string $name
     * @param string $email
     * @param string $subject
     * @param string $message
     */
    public function __construct()
    {
        $this->headers = new Headers();
    }

    /**
     * @param string $name
     *      The name of the sender
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     *      The name of the sender
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $email
     *      The email address of the sender
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     *      The email set for the sender
     */
    public function getEmail(): string
    {
        return $this->emai;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Performs the actual sending of the email
     */
    public function send(): bool
    {

        return false;
    }

    /**
     * The route callback for loading the form
     *
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

                         return $this->view->render($res, 'contact.twig', [
                             'title' => 'Contact'
                         ]);
                     });
            }
        };
    }
}
