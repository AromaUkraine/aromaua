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
// Отписка от рассылки
Route::get('/unsubscribe/{token}', 'SubscribeController@delete')->name('unsubscribe');




Route::group(['middleware' => ['auth', 'prepare.request']], function () {

    Route::group([
        'middleware' => ['role:developer|admin|manager', 'cmsLocale'],
        'prefix' => 'cms',
        'as' => 'root.' // этот алиас нужет чтобы модуль  попадал в основное меню cms
    ], function () {

        Route::get('newsletter', 'NewsletterController@index')->name('newsletter.index');
    });
});