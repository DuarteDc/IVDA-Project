<?php

use App\middlewares\AuthMiddleware;
use App\middlewares\HasAdminRole;

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

date_default_timezone_set($_ENV['TIMEZONE']);

$router = new \Bramus\Router\Router();

function sendCorsHeaders()
{
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, session");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
}

$router->options('/api.*', function() {
    sendCorsHeaders();
});

sendCorsHeaders();

$router->mount('/api.*', function () use ($router) {

    $router->post('/signin', '\App\controllers\SigninController@signin');
    $router->get('/me', '\App\controllers\SigninController@user');

    $router->before('GET', '/auth.*', function () { AuthMiddleware::checkAuth(); });

    $router->mount('/auth.*', function () use ($router) {
        $router->get('/users', 'App\controllers\UserController@index');
    });

    $router->get('/', 'App\controllers\HomeController@index');
    $router->get('/inventory', 'App\controllers\InventoryController@index');
    $router->post('/inventory', 'App\controllers\InventoryController@create');
    $router->get('/inventory/edit/{id}', 'App\controllers\InventoryController@edit');
    $router->get('/subsecretaries', 'App\controllers\SubSecretaryController@index');
    $router->get('/subsecretaries/create', 'App\controllers\SubSecretaryController@create');
    $router->get('/subsecretaries/{id}', 'App\controllers\SubSecretaryController@show');

    $router->get('/administrative-unit', 'App\controllers\AdministrativeUnitController@index');
    $router->get('/administrative-unit/create', 'App\controllers\AdministrativeUnitController@create');
    $router->post('/administrative-unit/save', 'App\controllers\AdministrativeUnitController@save');

    $router->post('/subsecretaries', 'App\controllers\SubSecretary@save');
    $router->get('/users/create', 'App\controllers\UserController@create');
    $router->get('/users/{id}', 'App\controllers\UserController@edit');
    $router->post('/users/save', 'App\controllers\UserController@save');
    $router->post('/users/{id}/update', 'App\controllers\UserController@update');
    $router->post('/users/{id}/delete', 'App\controllers\UserController@delete');
    $router->post('/users/{id}/active', 'App\controllers\UserController@active');
    $router->get('/profile', 'App\controllers\ProfileController@index');
    $router->post('/profile/update', 'App\controllers\ProfileController@update');
});


$router->get('/.*', '\App\controllers\SigninController@index');

$router->before('GET', '/', function () { AuthMiddleware::isAuthenticate(); });


$router->before('GET', '/auth.*', function () { AuthMiddleware::checkAuth(); HasAdminRole::hasUserRole();});

$router->set404('/.*', '\App\controllers\NotFoundController@__invoke');

$router->run();






