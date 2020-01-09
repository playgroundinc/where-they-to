<?php

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


// GET /projects 

Route::get('/', 'PagesController@home');

Route::resources([
  'users' => 'UserController',
  'performers' => 'PerformerController',
  'venues' => 'VenueController',
]);
