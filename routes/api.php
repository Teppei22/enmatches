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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ajax/messages','MessageController@index')->name('ajaxMsgs.index');
Route::post('/ajax/messages','MessageController@store')->name('ajaxMsgs.store');
Route::get('/ajax/messages/users','MessageController@getUser');


// Route::get('/ajax/messages','MessageController@index')->name('dmMsgs.index');