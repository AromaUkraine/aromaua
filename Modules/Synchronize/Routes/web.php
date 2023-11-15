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

Route::group(['middleware' => ['auth', 'prepare.request']], function () {

    Route::group([
        'middleware' => ['role:developer|admin|manager', 'cmsLocale'],
        'prefix' => 'cms',
        'as' => 'root.'// этот алиас нужет чтобы модуль  попадал в основное меню cms
    ], function () {

        Route::get('/synchronize-log', 'LogController@index')->name('log.index');
        Route::delete('/synchronize-log', 'LogController@destroy')->name('log.destroy');
    });
});
