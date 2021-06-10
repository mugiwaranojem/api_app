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
use App\Http\Controllers\CustomerController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/customers', [
	'uses' => 'CustomerController@index', 'as' => 'all_customers'
]);
$router->get('/customers/{customerId}', [
	'uses' => 'CustomerController@show', 'as' => 'customer_detail'
]);


/**
* More make sense to prefix api
*/
$router->group(['prefix' => 'api'], function () use ($router) {
	$router->get('customers',  ['uses' => 'CustomerController@index']);
});
