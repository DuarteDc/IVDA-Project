<?php

use App\middlewares\AuthMiddleware;

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$router = new \Bramus\Router\Router();
$router->before('GET', '/', function () { 
    $auth = new AuthMiddleware();
    $auth->isAuthenticate();
});

$router->get('/', '\App\controllers\SigninController@index');

$router->post('/signin', '\App\controllers\SigninController@signin');
   
$router->before('GET', '/auth.*', function () { 
    $auth = new AuthMiddleware();
    $auth->checkAuth();
});

$router->mount('/auth', function () use ($router) {
    $router->get('/', 'App\controllers\HomeController@index');
    $router->get('/inventario', 'App\controllers\InventoryController@index');
});

$router->set404('/.*', '\App\controllers\NotFoundController@__invoke');

$router->run();



