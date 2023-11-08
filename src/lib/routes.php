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
    $router->get('/inventory', 'App\controllers\InventoryController@index');
    $router->get('/users', 'App\controllers\UserController@index');
    $router->get('/users/create', 'App\controllers\UserController@create');
    $router->get('/users/{id}', 'App\controllers\UserController@edit');
    $router->post('/users/save', 'App\controllers\UserController@save');
    $router->post('/users/{id}/update', 'App\controllers\UserController@update');
    $router->post('/users/{id}/delete', 'App\controllers\UserController@delete');
    $router->post('/users/{id}/active', 'App\controllers\UserController@active');
    $router->get('/profile', 'App\controllers\ProfileController@index');
    $router->post('/profile/update', 'App\controllers\ProfileController@update');
});

$router->set404('/.*', '\App\controllers\NotFoundController@__invoke');

$router->run();




