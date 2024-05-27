<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->post('register', 'AuthController@register');
$router->post('login', 'AuthController@login');

// 在这里定义需要经过身份验证的路由
$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
    $router->put('logout', 'AuthController@logout');
    $router->get('profile', 'AutoController@profile');
    $router->put('refresh', 'AuthController@refresh');
    $router->put('profile', 'AuthController@profile');
});