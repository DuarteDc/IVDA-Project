<?php

use App\middlewares\AuthMiddleware;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

mb_internal_encoding('UTF-8');
set_time_limit(120);
date_default_timezone_set($_ENV['TIMEZONE']);
session_start();

$router = new \Bramus\Router\Router();

function sendCorsHeaders()
{
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, session");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}

$router->options('/api/.*', function () {
    sendCorsHeaders();
});
$router->mount('/api.*', function () use ($router) {
    
    $router->post('/signin', '\App\controllers\SigninController@signin');
    $router->get('/me', '\App\controllers\SigninController@user');
    
    $router->post('/recover-password', '\App\controllers\SigninController@recoverPassword');
    $router->get('/get-password-token', '\App\controllers\SigninController@getPasswordToken');
    $router->post('/change-password', '\App\controllers\SigninController@changePassword');
    
    $router->get('/seed-dependencies', '\App\lib\Seed@runSeedDependencies');
    $router->get('/seed-users', '\App\lib\Seed@runSeedUsers');
    

    $router->before('GET|POST|DELETE|PATCH', '/auth.*', function () {
        AuthMiddleware::checkAuth();
    });

    $router->mount('/auth.*', function () use ($router) {

        $router->get('/dashboard', 'App\controllers\HomeController@getDashboardData');

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
        $router->post('/inventories', 'App\controllers\InventoryController@save');
        $router->patch('/inventories/{id}', 'App\controllers\InventoryController@update');
        $router->post('/inventories/add-file/{id}', 'App\controllers\InventoryController@addFile');
        $router->delete('/inventories/remove-file/{id}/{no_file}', 'App\controllers\InventoryController@deleteFile');
        $router->get('/inventories/get/user', 'App\controllers\InventoryController@getInventoriesByUser');
        $router->get('/inventories/user', 'App\controllers\InventoryController@getInventoryByUser');
        $router->get('/inventories/{id}', 'App\controllers\InventoryController@show');
        $router->post('/inventories/finalize/{id}', 'App\controllers\InventoryController@finalizeInventory');

        $router->get('/dependencies', 'App\controllers\DependencyController@index');
        $router->get('/dependencies/user', 'App\controllers\DependencyController@getByUser');
        $router->patch('/dependencies/{id}', 'App\controllers\DependencyController@update');
        $router->post('/dependencies', 'App\controllers\DependencyController@save');
        $router->get('/dependencies/all', 'App\controllers\DependencyController@getAll');
        $router->delete('/dependencies/{id}', 'App\controllers\DependencyController@delete');
        $router->post('/dependencies/enable/{id}', 'App\controllers\DependencyController@active');
        $router->get('/dependencies/{id}', 'App\controllers\DependencyController@show');

        $router->get('/locations', 'App\controllers\LocationController@index');
        $router->post('/locations', 'App\controllers\LocationController@save');

        $router->get('/type-files', 'App\controllers\TypeFileController@index');
        $router->post('/type-files', 'App\controllers\TypeFileController@save');

        $router->get('/report/generate/{id}', 'App\controllers\ReportController@generateReport');

        $router->get('/profile', 'App\controllers\ProfileController@index');
        $router->post('/profile/update', 'App\controllers\ProfileController@update');

    });
});


$router->get('/.*', '\App\controllers\SigninController@index');

$router->set404('/.*', '\App\controllers\NotFoundController@__invoke');

$router->run();
