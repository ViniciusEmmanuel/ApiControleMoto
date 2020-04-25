<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

$router->post('/api/session', 'SessionController@store');

$router->post('/api/users', 'UserController@store');

$router->group(['prefix' => '/api', 'middleware' => 'auth'], function () use ($router) {

    $router->get('/maintenance', 'MaintenanceController@index');

    $router->post('/maintenance', 'MaintenanceController@store');

    $router->delete('/maintenance/{id}', 'MaintenanceController@destroy');

    $router->get('/gasoline', 'GasolineController@index');

    $router->post('/gasoline', 'GasolineController@store');

    $router->delete('/gasoline/{id}', 'GasolineController@destroy');

    $router->get('/motorcircles', 'MotorcicleController@index');

    $router->post('/motorcircles', 'MotorcicleController@store');

    $router->delete('/motorcircles/{id}', 'MotorcicleController@destroy');

    $router->get('/parts', 'PartsController@index');

    $router->post('/parts', 'PartsController@store');

});
