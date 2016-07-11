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

Route::get('/', function () {
    return view('welcome');
});

// Route::auth(); Replaced the original Route methods from /vendor/Laravel/src/Illuminate/Routing/Router.php::Auth()
// Registration Routes...
Route::get('register', 'Auth\AuthController@showRegistrationForm');
Route::post('register', 'Auth\AuthController@register');

Route::get('confirmation/{code}', 'Auth\EmailConfirmationController@verify');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');

// Authentication Routes...
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@loginByEmailOrUsername');
Route::get('logout', 'Auth\AuthController@logout');

Route::get('username', 'Auth\UsernameController@showForm');
Route::post('username', 'Auth\UsernameController@choose');

Route::get('/home', 'HomeController@index');
