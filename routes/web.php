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

Route::post('/families/performers/{id}', 'FamilyController@performer');
Route::post('/families/performers/{id}/destroy', 'FamilyController@performerDestroy');

Route::post('/events/{id}/tickets', 'EventController@createTickets');
Route::put('/events/{id}/tickets', 'EventController@updateTickets');

Route::resources([
  'performers' => 'PerformerController',
  'venues' => 'VenueController',
  'social-links' => 'SocialLinksController',
  'families' => 'FamilyController',
  'events' => 'EventController',
  'types' => 'TypeController',
  'user' => 'UserController'
]);

Route::post('/login', 'Api\AuthController@login')->name('login.api');
Route::post('/register', 'Api\AuthController@register')->name('register.api');

Route::group(['middleware' => 'auth:api'], function(){
  // Users
  Route::get('users', 'UserController@index')->middleware('isAdmin');
  Route::get('users/{id}', 'UserController@show')->middleware('isAdminOrSelf');
});

// Route to handle page reload in Vue except for api routes
Route::get('/{any?}', function (){
  return view('welcome');
})->where('any', '^(?!api\/)[\/\w\.-]*');


