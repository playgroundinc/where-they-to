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
Route::get('/social-links','SocialLinksController@index');
Route::post('/social-links', 'SocialLinksController@store');
Route::get('/social-links/create', 'SocialLinksController@create');
Route::delete('/social-links', 'SocialLinksController@destroy');
Route::get('/social-links/{id}', 'SocialLinksController@show');

Route::resources([
  'users' => 'UserController',
  'performers' => 'PerformerController',
  'venues' => 'VenueController',
]);
