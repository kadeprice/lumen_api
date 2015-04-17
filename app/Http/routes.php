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

//************ USERS ***********//
$app->get('api/v1/users', '\App\Http\Controllers\UsersController@index');

$app->post('api/v1/users','\App\Http\Controllers\UsersController@store');

$app->patch('api/v1/users','\App\Http\Controllers\UsersController@update');

$app->get('api/v1/users/{id}','\App\Http\Controllers\UsersController@show');

$app->get('api/v1/users/{id}/posts','\App\Http\Controllers\UsersController@get_posts');


//*********** POSTS **************//

$app->get('api/v1/posts', '\App\Http\Controllers\PostsController@index');

$app->get('api/v1/posts/{id}','\App\Http\Controllers\PostsController@show');

$app->post('api/v1/posts/{id}','\App\Http\Controllers\PostsController@store');

$app->patch('api/v1/posts/{id}','\App\Http\Controllers\PostsController@update');