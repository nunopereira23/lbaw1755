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
//Sign in form

Route::get('/sign_in', 'Auth\SignInController@show');

Route::get('/sign_up', function () {
    return view('auth.signUp');
});

Route::get('/index', function () {
    return view('pages.homepage');
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
Route::get('index', 'HomepageController@show');
Route::get('/','HomepageController@show');

// About
Route::get('about', 'AboutController@show');

// Contact
Route::get('contact', 'ContactController@show');

// FAQ
Route::get('faq', 'FaqController@show');

// Event
Route::get('event/{id}', 'EventController@show')->name('event');
Route::get('create_event', 'EventController@showCreateForm')->name('create_event');
Route::post('create_event', 'EventController@create');

//Profile
Route::get('/users/{id}/profile','ProfileController@show')->name('profile');
Route::get('/users/{id}/edit_profile','EditProfileController@show');
Route::post('/users/{id}/edit_profile','EditProfileController@update');
Route::post('/users/1/profile','ProfileController@showFirst');
