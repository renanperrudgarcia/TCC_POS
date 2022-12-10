<?php

/** @var \Slim\App $app */

use App\Api\Adapters\Http\ApiAction;

use App\Login\Adapters\Http\CreateUserApiAction;
use App\Login\Adapters\Http\LoginAction;
use App\Login\Adapters\Http\ValidateTokenAction;
use App\Middleware\AuthenticationMiddleware;


use App\Middleware\CorsMiddleware;
use App\Middleware\ExceptionNotFoundMiddleware;

use Slim\Interfaces\RouteCollectorProxyInterface;
use Slim\Factory\AppFactory;

//Here I pass the DI-PHP Container variable. So he performs the dependency injection
$app = AppFactory::createFromContainer($container);

$app->addBodyParsingMiddleware();

// This middleware will append the response header Access-Control-Allow-Methods with all allowed methods
$app->add(new CorsMiddleware());

// The RoutingMiddleware should be added after our CORS middleware so routing is performed first
$app->addRoutingMiddleware();


// Personalizando mensagens de retorno das exceptions padrões da aplicação
$app->add(ExceptionNotFoundMiddleware::class);

$app->group('/', function (RouteCollectorProxyInterface $group) {
    $group->get('', ApiAction::class);
});

$app->group('/api', function (RouteCollectorProxyInterface $group) {
    $group->post('/login', LoginAction::class);
    $group->post('/authorization', ValidateTokenAction::class);
    $group->post('/user', CreateUserApiAction::class); //->add(AuthenticationMiddleware::class);
});
