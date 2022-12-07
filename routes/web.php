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

// Welcome
Route::get('/', 'WelcomeController@index');

// Story Routes
Route::get('/stories', 'StoryController@index');
Route::get('/stories/{id}', 'StoryController@show');
ROute::get('/generate_stories', 'StoryController@store');

// Comments Routes
Route::get('/comments', 'CommentController@index');
ROute::get('/generate_comments', 'CommentController@store');
