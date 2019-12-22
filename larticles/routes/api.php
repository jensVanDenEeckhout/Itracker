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


// List articles
Route::get('articles', 'ArticleController@index');

// List single article
Route::get('article/{id}', 'ArticleController@show');

// Create new article
Route::post('article', 'ArticleController@store');

// update article
Route::put('article', 'ArticleController@store');

// delete article
Route::delete('article/{id}', 'ArticleController@destroy');




// List weight records
Route::get('weightRecords', 'ArticleController@index_weight');

// Create new article
Route::post('weightRecord1', 'ArticleController@store_weightRecord1');


// List articles
//Route::get('sleepRecords', 'ArticleController@index_sleep');



