<?php

use App\middlewares\AuthMiddleware;

session_start();
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$router = new \Bramus\Router\Router();
$router->before('GET|POST', '/', function () { 
    $auth = new AuthMiddleware();
    $auth->isAuthenticate();
});

$router->get('/', '\App\controllers\SigninController@index');

$router->post('/signin', '\App\controllers\SigninController@signin');

$router->before('GET|POST', '/auth.*', function () { 
    $auth = new AuthMiddleware();
    $auth->checkAuth();
});

$router->mount('/auth', function () use ($router) {
    $router->get('/', 'App\controllers\HomeController@index');
    $router->get('/inventario', function () {
            echo 'mundo';
    });
});

$router->set404('/.*', '\App\controllers\NotFoundController@__invoke');

$router->run();



