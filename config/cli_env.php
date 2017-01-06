<?php

/**
 * The `env` configuration set CLI environment variables. It is only set into
 * the container if the application is being run from the command line.
 */

if (php_sapi_name() === 'cli') {
    return [ 'is_cli' => false ];
}

$editor_name = 'vim';
$editor_path = exec("which {$editor_name}");
$user_name   = exec('whoami');

return [
    'is_cli' => true,
    'editor' => [
        'name' => $editor_name,
        'path' => $editor_path,
    ],
    'user' => $user_name,
];
