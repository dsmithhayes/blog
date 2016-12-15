<?php

/**
 * The entry point. Good luck!
 *
 * @author Dave Smith-Hayes <me@davesmithhayes.com>
 */

/**
 * Parse the request.
 */
$app = require_once __DIR__ . '/../bootstrap.php';


/**
 * Send the response.
 */
$app->run();
