<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Support\Facades\App;


$app->get('/', function() use ($app) {
    return "Hello World";
});


$app->get('api/v1/users', '\App\Http\Controllers\UsersController@index');

$app->post('api/v1/users','\App\Http\Controllers\UsersController@store');

$app->get('api/v1/user/{id}','\App\Http\Controllers\UsersController@show');

$app->get('api/v1/user/{id}/posts','\App\Http\Controllers\UsersController@get_posts');
