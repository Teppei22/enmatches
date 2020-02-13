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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function() {

    Route::get('/mypage', 'HomeController@index')->name('mypage');
    Route::get('/mypage/messages', 'HomeController@index')->name('mypage.message');

    Route::get('/profile', 'ProfileController@edit')->name('profile');
    Route::post('/profile', 'ProfileController@store')->name('profile.store');

    Route::get('/message', 'MessageController@create')->name('message');
    Route::get('/message/{message_type}', 'MessageController@show')->name('message.show');
    
    Route::get('/works/new', 'WorksController@create')->name('works.create');
    Route::post('/works/new', 'WorksController@store')->name('works.store');
    
    Route::post('/works/{id}', 'WorksController@update')->name('works.update');
    Route::get('/works/{id}/edit', 'WorksController@edit')->name('works.edit');
    Route::post('/works/{id}/delete', 'WorksController@delete')->name('works.delete');
    Route::post('/works/work_id={work_id}/user_id={user_id}/apply', 'WorksController@applyWork')->name('works.apply');
    Route::get('/works/{id}/like', 'WorksController@likeWork')->name('works.like');

    
});

Route::get('/user/{id}', 'ProfileController@show')->name('profile.show');

Route::get('/works', 'WorksController@index')->name('works.index');
Route::get('/works/{id}', 'WorksController@show')->name('works.show');


Route::get('/ajax/messages','MessageController@index')->name('ajaxMsgs.index');
Route::post('/ajax/messages','MessageController@store')->name('ajaxMsgs.store');
Route::get('/ajax/messages/users','MessageController@getUser');

Auth::routes();
