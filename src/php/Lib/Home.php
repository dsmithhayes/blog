<?php

namespace Blog\Lib;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use cebe\markdown\GithubMarkdown;

class Home
{
    /**
     * Return the about blurb from a markdown file.
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $req
     *      Instance of the current request
     * @param \Psr\Http\Message\ResponseInterface $res
     *      Instance of the response
     * @return \Psr\Http\Message\ResponseInterface
     *      The modified response
     */
    public function about(Request $req, Response $res): Response
    {

        return $res;
    }
}
