<?php

//Route::get('/maps',[
//    'as'=>'maps',
//    'uses' => 'MapsController@index'
//]);

// =============================================== General
use Illuminate\Support\Facades\Route;

Route::get('/', [
    'as'   => 'home',
    'uses' => 'HomeController@index'
]);

// =============================================== Account
Route::get('account/logout', [
    'as'   => 'account.logout',
    'uses' => 'AccountController@getLogout'
]);

Route::get('account/myprofile', [
    'as'   => 'account.myprofile',
    'uses' => 'AccountController@getPersonalProfile'
]);

Route::post('account/updateProfile', [
    'as'   => 'account.updateProfile',
    'uses' => 'AccountController@update'
]);

Route::post('account/sendActivate', [
    'as'   => 'account.sendActivationCode',
    'uses' => 'AccountController@sendActivate'
]);

Route::get('/account/activate/{code}', [
    'as'   => 'account.activate',
    'uses' => 'AccountController@getActivate'
]);

Route::get('/account/myprofile/trips', [
    'as'   => 'account.trips',
    'uses' => 'AccountController@getPersonalTrips'
]);

Route::get('/account/editAccount/{id}', [
    'as'   => 'account.editAccount',
    'uses' => 'AccountController@getEditAccount'
]);

Route::post('/account/newVehicle/', [
    'as'   => 'account.newVehicle',
    'uses' => 'AccountController@saveNewVehicle'
]);

Route::resource('account', 'AccountController',
    ['except' => ['index', 'destroy']]);

Route::controller('password', 'RemindersController');

// =============================================== Trips
Route::post('trips/{trip_id}/apply/{user_id}', [
    'as'   => 'trips.apply',
    'uses' => 'TripsController@applyForTrip'
]);

Route::delete('trips/{trip_id}/resign/{user_id}', [
    'as'   => 'trips.resign',
    'uses' => 'TripsController@resignFromTrip'
]);

Route::resource('trips', 'TripsController');

// ================================================ AJAX
Route::get('/Ajax/getTeaser', [
    'as'   => 'ajax.getTeaser',
    'uses' => 'AjaxController@getTeaser'
]);

Route::post('/Ajax/login', [
    'as'   => 'ajax.login',
    'uses' => 'AjaxController@postLogin'

]);

Route::post('/Ajax/uploadProfilePic', [
    'as'   => 'ajax.uploadProfilePic',
    'uses' => 'AjaxController@uploadProfilePic'
]);

Route::get('/Ajax/uploadProfilePic', [
    'as'   => 'ajax.uploadProfilePic',
    'uses' => 'AjaxController@uploadProfilePic'
]);

// ================================================ Search
Route::get('search/trips', [
    'as'   => 'search.trips',
    'uses' => 'SearchController@searchTrips'
]);

// ================================================ Error
Route::get('wrong-page', [
    'as'   => 'wrong-page',
    'uses' => 'ErrorController@wrongPage'
]);