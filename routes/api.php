<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'namespace' => 'Api',
], function () {

    /*** запросы связаные с текущей локалью ***/
    Route::group([
        'middleware' => ['apiLocale'],
    ], function () {
        /*** get products on page by alias ***/
        Route::get('contact/central-office', 'ContactController@central')->name('get_central_office');
        Route::get('contact/countries', 'ContactController@countries')->name('get_countries');
        Route::get('contact/offices', 'ContactController@offices')->name('get_offices_with_country');

        /*** get products on catalog ***/
        Route::post('products', 'ProductController@index')->name('products');
        Route::post('products/features', 'ProductController@features')->name('products.features');

        Route::get('products/demo', 'ProductController@demo');
    });
});


/*** cms helpers ****/
Route::post('sortable', 'Api\SortableController@index')->name('sortable');
Route::post('move', 'Api\NestedTreeController@move')->name('move');
Route::post('slug', 'Api\SlugController@index')->name('slug');
Route::post('checked', 'Api\CheckedController@index')->name('checked');
Route::get('language/switch', 'Api\LanguageController@switch')->name('language_switch');
Route::get('cms_search', 'Api\CmsSearchController@index')->name('cms_search');
