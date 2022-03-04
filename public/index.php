<?php

use core\logs\ErrorLog;
use Slim\Factory\AppFactory;
use AlexUnruh\Config\Config;
use core\middlewares\JsonParser;
use Slim\Routing\RouteCollectorProxy;

require dirname(__DIR__) . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createMutable(dirname(__DIR__));
$dotenv->safeLoad();

Config::setDir(dirname(__DIR__) . '/app/config');

// Configure app
$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->setBasePath($_ENV['BASE_PATH']);
$errorHandler = new ErrorLog($app->getCallableResolver(), $app->getResponseFactory());
$errorMiddleware = $app->addErrorMiddleware($_ENV['APP_DEBUG'], true, true);

// Insert routes
$app->group('/', function (RouteCollectorProxy $route) {
  require_once(dirname(__DIR__) . '/routes/web.php');
});

$app->group('/api', function (RouteCollectorProxy $route) {
  require_once(dirname(__DIR__) . '/routes/api.php');
})->add(JsonParser::class);

$app->group('/admin', function (RouteCollectorProxy $route) {
  require_once(dirname(__DIR__) . '/routes/admin.php');
});

$errorMiddleware->setDefaultErrorHandler($errorHandler);
$app->run();
