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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    Route::post('files/get', 'FileController@get');
    Route::post('files/download', 'FileController@download');
    Route::post('files/upload', 'FileController@upload');
    Route::post('files/update', 'FileController@update');
    Route::post('files/delete', 'FileController@delete');
    Route::post('files/moveFileDown', 'FileController@moveFileDown');
    Route::post('files/moveFileUp', 'FileController@moveFileUp');

    Route::post('categories/get', 'CategoryController@get');
    Route::post('categories/create', 'CategoryController@create');
    Route::post('categories/update', 'CategoryController@update');
    Route::post('categories/delete', 'CategoryController@delete');

    Route::post('playlists/get', 'PlaylistController@get');
    Route::post('playlists/create', 'PlaylistController@create');
    Route::post('playlists/update', 'PlaylistController@update');
    Route::post('playlists/delete', 'PlaylistController@delete');

    Route::post('export/generate', 'ExportController@generate');

    Route::post('import/upload', 'ImportController@upload');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
