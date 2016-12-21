<?php

namespace Blog\Lib;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Blog\Lib\Route;
use cebe\markdown\GithubMarkdown;

class Home
{
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
