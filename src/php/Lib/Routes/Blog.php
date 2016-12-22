<?php

namespace Blog\Lib\Routes;

use Blog\Lib\Route;
use Blog\Lib\Routes\Post;

class Blog
{
    public function index(Container $container): Route
    {
        return class($container) extends Route {
            public function __construct($container)
            {
                $this->setContainer($container);
            }
        };
    }
}
