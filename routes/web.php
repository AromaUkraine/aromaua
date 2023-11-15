<?php


use App\Facades\Localization;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => Localization::locale(),
    'middleware' => ['setLocale'],
], function () {
    Auth::routes(['register' => false, 'reset' => false]);
});

Route::group(['namespace' => 'Web'], function () {
    Route::get('/synchronize/import', 'SynchronizeController@import')->name('synchronize.import');
});

