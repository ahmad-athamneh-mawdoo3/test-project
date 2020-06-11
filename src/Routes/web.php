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
Route::get('test', 'mawdoo3\test\Controllers\SearchController@testRoute')->name('asasdasad');
Route::prefix('search')->namespace('mawdoo3\test\Controllers')->group(function () {
    Route::get('/saved', 'SearchController@savedResults')->name('savedResults');
    Route::get('/{searchWord?}', 'SearchController@search')->name('searchIndex');
    Route::post('/', 'SearchController@save')->name('saveResults');
    
    Route::post('/{id}', 'SearchController@chooseAction')->name('chooseAction');
    
});

