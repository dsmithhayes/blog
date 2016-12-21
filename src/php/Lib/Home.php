<?php

namespace Blog\Lib;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Interop\Container\ContainerInterface as Container;
use cebe\markdown\GithubMarkdown;
use Blog\Lib\Route;

class Home
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function about(): Route
    {
        return new class extends Route {
            public function __construct()
            {
                $this->setName('about')
                     ->setMethod('get')
                     ->setRoute('/[home]')
                     ->setCallback(function (Request $req, Response $res) {

                     });
            }
        }
    }
}
