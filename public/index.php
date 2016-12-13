<?php

$app = require_once __DIR__ . '/../bootstrap.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Send the response to the client.
 */
$app->run();
