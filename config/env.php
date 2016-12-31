<?php

/**
 * The `env` configuration set CLI environment variables. It is only set into
 * the container if the application is being run from the command line.
 */

$editor = exec('wich vim');
$user   = exec('whoami');

return [
    'editor' => $editor,
    'user'   => $user,
];
