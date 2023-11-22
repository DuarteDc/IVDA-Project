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
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH');
}

$router->options('/api.*', function () {
    sendCorsHeaders();
});


$router->mount('/api.*', function () use ($router) {

    $router->post('/signin', '\App\controllers\SigninController@signin');
    $router->get('/me', '\App\controllers\SigninController@user');

    $router->before('GET|POST|DELETE|PATCH', '/auth.*', function () {
        AuthMiddleware::checkAuth();
    });

    $router->mount('/auth.*', function () use ($router) {

        $router->get('/users', 'App\controllers\UserController@index');
        $router->get('/users/{id}', 'App\controllers\UserController@show');
        $router->post('/users/save', 'App\controllers\UserController@save');
        $router->delete('/users/{id}', 'App\controllers\UserController@delete');
        $router->post('/users/active/{id}', 'App\controllers\UserController@active');
        $router->patch('/users/{id}', 'App\controllers\UserController@update');

        $router->get('/subsecretaries', 'App\controllers\SubSecretaryController@index');
        $router->get('/subsecretaries/{id}', 'App\controllers\SubSecretaryController@show');
        $router->post('/subsecretaries', 'App\controllers\SubSecretaryController@save');
        $router->patch('/subsecretaries/{id}', 'App\controllers\SubSecretaryController@update');
        $router->delete('/subsecretaries/{id}', 'App\controllers\SubSecretaryController@delete');
        $router->get('/subsecretaries-all', 'App\controllers\SubSecretaryController@getAll');
        $router->post('/subsecretaries/active/{id}', 'App\controllers\SubSecretaryController@active');
        
        $router->get('/inventories', 'App\controllers\InventoryController@index');
        $router->post('/inventories', 'App\controllers\InventoryController@create');
        $router->get('/inventories/edit/{id}', 'App\controllers\InventoryController@edit');
        

        $router->get('/administrative-units', 'App\controllers\AdministrativeUnitController@index');
        $router->get('/administrative-units/{id}', 'App\controllers\AdministrativeUnitController@show');
        $router->post('/administrative-units', 'App\controllers\AdministrativeUnitController@save');
        $router->get('/administrative-units/all', 'App\controllers\AdministrativeUnitController@getAll');
        $router->get('/administrative-units/subsecretary/{subsecretary_id}', 'App\controllers\AdministrativeUnitController@getBySubsecretary');
        $router->delete('/administrative-units/{id}', 'App\controllers\AdministrativeUnitController@delete');
        $router->post('/administrative-units/enable/{id}', 'App\controllers\AdministrativeUnitController@active');

        
        $router->get('/users/create', 'App\controllers\UserController@create');
        $router->post('/users/save', 'App\controllers\UserController@save');
        
        $router->post('/users/{id}/delete', 'App\controllers\UserController@delete');
        
        $router->get('/profile', 'App\controllers\ProfileController@index');
        $router->post('/profile/update', 'App\controllers\ProfileController@update');
    });
});


$router->get('/.*', '\App\controllers\SigninController@index');

$router->before('GET', '/', function () {
    // AuthMiddleware::isAuthenticate();
});


$router->before('GET', '/auth.*', function () {
    // AuthMiddleware::checkAuth();
    
});

$router->set404('/.*', '\App\controllers\NotFoundController@__invoke');

$router->run();
