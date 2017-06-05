<?php

require __DIR__.'/../vendor/autoload.php';

$app = (new \Duktig\Core\AppFactory)->make(
    __DIR__.'/../src/Config/config.php',
    \Duktig\Core\App::class
);
$app->run()->sendResponse()->terminate();
