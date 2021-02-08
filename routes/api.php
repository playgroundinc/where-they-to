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
Route::post('user/existing', 'UserController@existing');

Route::group(['middleware' => ['jwt.verify']], function() {

    Route::post('user/{id}/attendance', 'UserController@toggleAttendance');
    Route::post('user/{id}/follow/venue', 'UserController@toggleVenueFollowing');
    Route::post('user/{id}/follow/performer', 'UserController@togglePerformerFollowing');
    Route::post('user/{id}/follow/family', 'UserController@toggleFamilyFollowing');

    Route::get('user', 'UserController@getAuthenticatedUser');

    Route::post('events', 'EventController@store');
    Route::put('events/{id}', 'EventController@update');
    Route::delete('events/{id}', 'EventController@destroy');

    Route::put('families/{id}', 'FamilyController@update');
    Route::delete('families/{id}', 'FamilyController@destroy');
    Route::post('families', 'FamilyController@store');

    Route::post('performers', 'PerformerController@store');
    Route::delete('performers/{id}', 'PerformerController@destroy');
    Route::put('performers/{id}', 'PerformerController@edit');
    Route::put('performers/{id}/performerType', 'PerformerController@addType');
    Route::delete('performers/{id}/performerType', 'PerformerController@removeType');

    Route::post('social-links', 'SocialLinksController@store');
    Route::put('social-links/{id}', 'SocialLinksController@update');
    Route::delete('social-links/{id}', 'SocialLinksController@destroy');
    
    Route::put('venues/{id}', 'VenueController@update');
    Route::post('venues', 'VenueController@store');
    Route::delete('venues/{id}', 'VenueController@destroy');    

    Route::post('types', 'TypeController@store');

    Route::post('updates', 'UpdateController@store');

    Route::post('{province}/cities', 'CityController@store');
});

Route::get('performers', 'PerformerController@index');
Route::get('performers/{id}', 'PerformerController@show');
Route::get('performers/{id}/events', 'PerformerController@events');
Route::post('performers/names', 'PerformerController@getNames');

Route::get('venues', 'VenueController@index');
Route::get('venues/{id}', 'VenueController@show');

Route::get('social-links', 'SocialLinksController@index');
Route::get('social-links/{id}', 'SocialLinksController@show');

Route::get('families', 'FamilyController@index');
Route::get('families/{id}', 'FamilyController@show');

Route::get('events', 'EventController@index');
Route::get('events/{id}', 'EventController@show');
Route::get('events/date/{date}', 'EventController@date');
Route::get('events/week/{date}', 'EventController@week');

Route::get('{province}/cities', 'CityController@index');
Route::get('single/{province}/{city}', 'CityController@single');


Route::resources([
  'users' => 'UserController',
]);

Route::get('/performerTypes', 'TypeController@performerIndex');
Route::get('/eventTypes', 'TypeController@eventIndex');
Route::post('/eventTypes', 'TypeController@eventStore');
Route::post('/performerTypes', 'TypeController@performerStore');

// SEARCH
Route::get('/eventTypes/search/{term}', 'TypeController@eventSearch');
Route::get('/performerTypes/search/{term}', 'TypeController@performerSearch');
Route::get('performers/search/{term}', 'PerformerController@search');
Route::get('/venues/search/{term}', 'VenueController@search');
Route::get('/families/search/{term}', 'FamilyController@search');
Route::get('/cities/{province}/search/{term}', 'CityController@search');
