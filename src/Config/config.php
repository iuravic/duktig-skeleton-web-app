<?php
/**
 * Your application's configuration file, values based on Core/config.php.
 */
return [
    'env' => 'prod',
    'log' => __DIR__.'/../../var/log/log.log',
    'appDir' => dirname(__DIR__),
    'view' => [
        'templateCache' => false,
    ],
    'services' => include 'services.php',
    'params' => include 'params.php',
    'routes' => include 'routes.php',
    'appMiddlewares' => include 'middlewares.php',
    'events' => include 'events.php',
];