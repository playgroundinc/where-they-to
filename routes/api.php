<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth/register', 'UserController@register');
Route::post('auth/login', 'UserController@authenticate');
Route::get('user/{id}/profile', 'UserController@profile');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::put('performers/{id}', 'PerformerController@update');
    Route::post('performers', 'PerformerController@store');
    Route::delete('performers/{id}', 'PerformerController@destroy');    
    Route::put('performers/social-links/{id}', 'SocialLinksController@update');
    
    Route::put('venues/{id}', 'VenueController@update');
    Route::post('venues', 'VenueController@store');
    Route::delete('venues/{id}', 'VenueController@destroy');    
    Route::put('venues/social-links/{id}', 'SocialLinksController@update');
    Route::post('social-links', 'SocialLinksController@store');
    Route::delete('social-links/{id}', 'SocialLinksController@destroy');
});

Route::get('performers', 'PerformerController@index');
Route::get('performers/{id}', 'PerformerController@show');

Route::get('venues', 'VenueController@index');
Route::get('venues/{id}', 'VenueController@show');

Route::get('social-links', 'SocialLinksController@index');
Route::get('social-links/{id}', 'SocialLinksController@show');

Route::resources([
  'users' => 'UserController',
  'events' => 'EventController',
  'families' => 'FamilyController',
]);

Route::get('/performerTypes', 'TypeController@performerIndex');
