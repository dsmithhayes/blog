<?php

/**
 * The `env` configuration set CLI environment variables. It is only set into
 * the container if the application is being run from the command line.
 */
return [
    'editor' => exec('which vim'),
];
