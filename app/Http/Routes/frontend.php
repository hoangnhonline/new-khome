<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::post('/get-child', ['uses' => 'Frontend\HomeController@getChild', 'as' => 'get-child']);
Route::group(['namespace' => 'Frontend'], function()
{
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('book-{id}.html', ['as' => 'book', 'uses' => 'HomeController@book']);        
    Route::get('folder-{id}.html', ['as' => 'folder', 'uses' => 'HomeController@folder']);
    Route::get('chapter-{id}.html', ['as' => 'chapter', 'uses' => 'HomeController@chapter']);    
});

