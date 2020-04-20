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

$router->post('/users', 'UserController@store');

$router->group(['prefix' => '/api', 'middleware' => 'auth'], function () use ($router) {

    $router->get('/gasoline', 'GasolineController@index');

    $router->post('/gasoline', 'GasolineController@store');

});
