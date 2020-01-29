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
    Route::get('closed', 'DataController@closed');
});

Route::resources([
  'performers' => 'PerformerController',
  'users' => 'UserController',
  'events' => 'EventController',
  'venues' => 'VenueController',
  'families' => 'FamilyController',
  'social-links' => 'SocialLinksController',
]);

Route::put('/performers/{id}', 'PerformerController@update');

Route::get('/performerTypes', 'TypeController@performerIndex');
