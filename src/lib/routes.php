<?php

use App\middlewares\AuthMiddleware;
use App\middlewares\HasAdminRole;

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

date_default_timezone_set($_ENV['TIMEZONE']);

$router = new \Bramus\Router\Router();

$router->setBasePath('/');

$router->before('GET', '/', function () { AuthMiddleware::isAuthenticate(); });

$router->get('/', '\App\controllers\SigninController@index');

$router->post('/signin', '\App\controllers\SigninController@signin');
   
$router->before('GET', '/auth.*', function () { AuthMiddleware::checkAuth(); HasAdminRole::hasUserRole();});

$router->mount('/auth', function () use ($router) {
    $router->get('/', 'App\controllers\HomeController@index');
    $router->get('/inventory', 'App\controllers\InventoryController@index');
    $router->post('/inventory', 'App\controllers\InventoryController@create');
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

$router->mount('/user', function () use ($router) {
    $router->get('/', function() {
        echo "xd";
    });
});
$router->set404('/.*', '\App\controllers\NotFoundController@__invoke');

$router->run();




