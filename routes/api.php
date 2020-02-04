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

    Route::put('events/{id}/tickets', 'EventController@addTicket');
    Route::delete('events/{id}/tickets', 'EventController@deleteTicket');

    Route::put('events/{id}/performers', 'EventController@addPerformer');
    Route::delete('events/{id}/performers', 'EventController@deletePerformer');

    Route::post('events', 'EventController@store');
    Route::put('events/{id}', 'EventController@update');
    Route::delete('events/{id}', 'EventController@destroy');

    Route::delete('families/performers/{id}/delete', 'FamilyController@performerDestroy');
    Route::put('families/{id}', 'FamilyController@update');
    Route::post('families', 'FamilyController@store');
    Route::post('families/{id}/performer', 'FamilyController@performer');

    
    Route::post('performers', 'PerformerController@store');
    Route::delete('performers/{id}', 'PerformerController@destroy');
    Route::put('performers/{id}', 'PerformerController@update');

    Route::post('social-links', 'SocialLinksController@store');
    Route::put('social-links/{id}', 'SocialLinksController@update');
    Route::delete('social-links/{id}', 'SocialLinksController@destroy');

    Route::post('tickets', 'TicketController@store');
    
    Route::put('venues/{id}', 'VenueController@update');
    Route::post('venues', 'VenueController@store');
    Route::delete('venues/{id}', 'VenueController@destroy');    

});

Route::get('performers', 'PerformerController@index');
Route::get('performers/{id}', 'PerformerController@show');

Route::get('venues', 'VenueController@index');
Route::get('venues/{id}', 'VenueController@show');

Route::get('social-links', 'SocialLinksController@index');
Route::get('social-links/{id}', 'SocialLinksController@show');

Route::get('tickets', 'TicketController@index');

Route::get('families', 'FamilyController@index');

Route::get('events', 'EventController@index');


Route::resources([
  'users' => 'UserController',
]);

Route::get('/performerTypes', 'TypeController@performerIndex');
Route::get('/eventTypes', 'TypeController@eventIndex');
