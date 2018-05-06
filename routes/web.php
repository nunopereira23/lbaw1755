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

//Error page
Route::get('/error', function () {
    return view('pages.error');
});

// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//Homepage
Route::get('index', 'HomepageController@show')->name('home');
Route::get('/','HomepageController@show');

// About
Route::get('about', 'AboutController@show');

// Contact
Route::get('contact', 'ContactController@show');

// FAQ
Route::get('faq', 'FaqController@show');

//Admin
Route::get('users', 'AdminController@showActiveUsers');
Route::get('banned_users', 'AdminController@showBannedUsers');
Route::get('reports', 'AdminController@showReports');
Route::post('/users/{id}/ban', 'AdminController@ban');
Route::post('/users/{id}/reinstate', 'AdminController@reinstate');
Route::post('/users/{id}/warn', 'AdminController@warn');

// Event
Route::get('event/{id}', 'EventController@show')->name('event');
Route::post('event/{id}', 'EventController@request');
Route::get('create_event', 'EventController@showCreateForm')->name('create_event');
Route::post('create_event', 'EventController@create');

Route::get('event/{id}/edit_event', 'EventController@showEditForm')->name('edit_event');
Route::post('event/{id}/edit_event', 'EventController@update');

//Events
Route::get('events', 'EventsController@show');

//My events
Route::get('/users/{id}/my_events', 'MyEventsController@show');
Route::get('/users/{id}/past_events', 'MyEventsController@showPast');

//Profile
Route::get('/users/{id}/profile','ProfileController@show')->name('profile');
Route::get('/users/{id}/edit_profile','EditProfileController@show');
Route::post('/users/{id}/edit_profile','EditProfileController@update');
Route::get('my_profile','ProfileController@showLoggedInUser')->name('my_profile');
Route::post('/users/{id}/report','ReportController@report');
