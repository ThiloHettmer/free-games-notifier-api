<?php

use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Initiate the slim app with settings
 */
$settings = require __DIR__ . '/../src/settings.php';

$app = AppFactory::create();

date_default_timezone_set('Europe/Berlin');

/**
 * Register routes
 */
$routes = require __DIR__ . '/../src/routes.php';
$routes($app);

$app->run();
