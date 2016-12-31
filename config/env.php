<?php

/**
 * The `env` configuration set CLI environment variables. It is only set into
 * the container if the application is being run from the command line.
 */

if (php_sapi_name() === 'cli') {
    return [];
}

$editor_name = 'vim';
$editor_path = exec("wich {$editor_name}");
$user        = exec('whoami');

return [
    'editor' => [
        'name' => $editor_name,
        'path' => $editor_path,
    ],
    'user'   => $user,
];
