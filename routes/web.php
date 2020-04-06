<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'LandingController@index')->name('landing');

Route::middleware(['auth'])->group(function() {
  Route::get('/home', 'HomeController@index')->name('home');
});

// Authentication handling
Route::get('/login', 'LoginController@show')->name('login');
Route::post('/login', 'LoginController@login');
Route::get('/signup', 'RegistrationController@show')->name('signup');
Route::post('/signup', 'RegistrationController@register');
Route::get('/logout', 'LogoutController');

Route::get('/info/{topic}', 'InfoController@index');
