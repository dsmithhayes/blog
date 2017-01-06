<?php

/**
 * This file defines all of the routes for the application.
 */

use Blog\Lib\{Route, Router};
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Blog\Lib\Routes\{Home, Contact, Blog};

// implictly grab the $app from the bootstrapping file
$container = $app->getContainer();

return new Router([
    // Home page
    (new Home())->index(),

    // Contact page
    (new Contact())->index(),
    (new Contact())->handleForm(),

    // Blog posts
    (new Blog())->index(),
]);
