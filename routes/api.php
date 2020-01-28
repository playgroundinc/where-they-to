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
Route::get('open', 'DataController@open');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('closed', 'DataController@closed');
});

Route::resources([
  'performers' => 'PerformerController',
  'users' => 'UserController',
  'events' => 'EventController',
  'venues' => 'VenueController',
  'families' => 'FamilyController',
]);

Route::get('/performerTypes', 'TypeController@performerIndex');
