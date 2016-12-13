<?php

namespace Blog\Lib;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Controller
{
    protected $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function render()
    {
        return $this->view->render();
    }
}
