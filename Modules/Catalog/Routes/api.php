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

//Route::middleware('auth:api')->post('/catalog', function (Request $request) {
//    return $request->user();
//})->name('api-test');

Route::group([
    'namespace' =>'Api',
], function () {

    Route::post('/seo_catalog/features','SeoCatalogController@features')->name('get-features');
    Route::post('/seo_catalog/feature_values','SeoCatalogController@feature_values')->name('get-feature-values');

    Route::post('feature-value/get-input-name', 'FeatureValueController@get_name')->name('get-feature-value-name');
});

