<?php
// Authentication routes...
Route::get('backend/login', ['as' => 'backend.login-form', 'uses' => 'Backend\UserController@loginForm']);
Route::post('backend/login', ['as' => 'backend.check-login', 'uses' => 'Backend\UserController@checkLogin']);
Route::get('backend/logout', ['as' => 'backend.logout', 'uses' => 'Backend\UserController@logout']);
Route::group(['namespace' => 'Backend', 'prefix' => 'backend', 'middleware' => 'isAdmin'], function()
{    
    Route::get('dashboard', ['as' => 'dashboard.index', 'uses' => "SettingsController@dashboard"]);
    Route::post('save-content', ['as' => 'save-content', 'uses' => "SettingsController@saveContent"]);
   
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', ['as' => 'settings.index', 'uses' => 'SettingsController@index']);
        Route::post('/update', ['as' => 'settings.update', 'uses' => 'SettingsController@update']);
        Route::get('/noti', ['as' => 'settings.noti', 'uses' => 'SettingsController@noti']);        
        Route::post('/storeNoti', ['as' => 'settings.store-noti', 'uses' => 'SettingsController@storeNoti']);
    });  
    Route::group(['prefix' => 'folder'], function () {
        Route::get('/', ['as' => 'folder.index', 'uses' => 'FolderController@index']);
        Route::get('/create', ['as' => 'folder.create', 'uses' => 'FolderController@create']);
        Route::post('/store', ['as' => 'folder.store', 'uses' => 'FolderController@store']);
        Route::get('{id}/edit',   ['as' => 'folder.edit', 'uses' => 'FolderController@edit']);
        Route::post('/update', ['as' => 'folder.update', 'uses' => 'FolderController@update']);
        Route::get('{id}/destroy', ['as' => 'folder.destroy', 'uses' => 'FolderController@destroy']);
    });
    Route::group(['prefix' => 'book'], function () {
        Route::get('/', ['as' => 'book.index', 'uses' => 'BookController@index']);
        Route::get('/create', ['as' => 'book.create', 'uses' => 'BookController@create']);
        Route::post('/store', ['as' => 'book.store', 'uses' => 'BookController@store']);
        Route::get('{id}/edit',   ['as' => 'book.edit', 'uses' => 'BookController@edit']);
        Route::post('/update', ['as' => 'book.update', 'uses' => 'BookController@update']);
        Route::get('{id}/destroy', ['as' => 'book.destroy', 'uses' => 'BookController@destroy']);
    });
    Route::group(['prefix' => 'audio'], function () {
        Route::get('/', ['as' => 'audio.index', 'uses' => 'AudioController@index']);
        Route::get('/create', ['as' => 'audio.create', 'uses' => 'AudioController@create']);
        Route::post('/store', ['as' => 'audio.store', 'uses' => 'AudioController@store']);
        Route::get('{id}/edit',   ['as' => 'audio.edit', 'uses' => 'AudioController@edit']);
        Route::post('/update', ['as' => 'audio.update', 'uses' => 'AudioController@update']);
        Route::get('{id}/destroy', ['as' => 'audio.destroy', 'uses' => 'AudioController@destroy']);
    });
    Route::group(['prefix' => 'album'], function () {
        Route::get('/', ['as' => 'album.index', 'uses' => 'AlbumController@index']);
        Route::get('/create', ['as' => 'album.create', 'uses' => 'AlbumController@create']);
        Route::post('/store', ['as' => 'album.store', 'uses' => 'AlbumController@store']);
        Route::get('{id}/edit',   ['as' => 'album.edit', 'uses' => 'AlbumController@edit']);
        Route::post('/update', ['as' => 'album.update', 'uses' => 'AlbumController@update']);
        Route::get('{id}/destroy', ['as' => 'album.destroy', 'uses' => 'AlbumController@destroy']);
    });
    Route::group(['prefix' => 'chapter'], function () {
        Route::get('/', ['as' => 'chapter.index', 'uses' => 'ChapterController@index']);
        Route::get('/create', ['as' => 'chapter.create', 'uses' => 'ChapterController@create']);
        Route::post('/store', ['as' => 'chapter.store', 'uses' => 'ChapterController@store']);
        Route::get('{id}/edit',   ['as' => 'chapter.edit', 'uses' => 'ChapterController@edit']);
        Route::post('/update', ['as' => 'chapter.update', 'uses' => 'ChapterController@update']);
        Route::get('{id}/destroy', ['as' => 'chapter.destroy', 'uses' => 'ChapterController@destroy']);
    });
    Route::group(['prefix' => 'author'], function () {
        Route::get('/', ['as' => 'author.index', 'uses' => 'AuthorController@index']);
        Route::get('/create', ['as' => 'author.create', 'uses' => 'AuthorController@create']);
        Route::post('/store', ['as' => 'author.store', 'uses' => 'AuthorController@store']);
        Route::get('{id}/edit',   ['as' => 'author.edit', 'uses' => 'AuthorController@edit']);
        Route::post('/update', ['as' => 'author.update', 'uses' => 'AuthorController@update']);
        Route::get('{id}/destroy', ['as' => 'author.destroy', 'uses' => 'AuthorController@destroy']);
    });
    Route::group(['prefix' => 'page'], function () {
        Route::get('/', ['as' => 'page.index', 'uses' => 'PageController@index']);
        Route::get('/create', ['as' => 'page.create', 'uses' => 'PageController@create']);
        Route::post('/store', ['as' => 'page.store', 'uses' => 'PageController@store']);
        Route::get('{id}/edit',   ['as' => 'page.edit', 'uses' => 'PageController@edit']);
        Route::post('/update', ['as' => 'page.update', 'uses' => 'PageController@update']);
        Route::get('{id}/destroy', ['as' => 'page.destroy', 'uses' => 'PageController@destroy']);
    });
    Route::post('/tmp-upload', ['as' => 'image.tmp-upload', 'uses' => 'UploadController@tmpUpload']);
    Route::post('/tmp-upload-multiple', ['as' => 'image.tmp-upload-multiple', 'uses' => 'UploadController@tmpUploadMultiple']);
        
    Route::post('/update-order', ['as' => 'update-order', 'uses' => 'GeneralController@updateOrder']);
    Route::post('/ck-upload', ['as' => 'ck-upload', 'uses' => 'UploadController@ckUpload']);
    Route::post('/get-slug', ['as' => 'get-slug', 'uses' => 'GeneralController@getSlug']);

    Route::group(['prefix' => 'account'], function () {
        Route::get('/', ['as' => 'account.index', 'uses' => 'AccountController@index']);
        Route::get('/change-password', ['as' => 'account.change-pass', 'uses' => 'AccountController@changePass']);
        Route::post('/store-password', ['as' => 'account.store-pass', 'uses' => 'AccountController@storeNewPass']);
        Route::get('/update-status/{status}/{id}', ['as' => 'account.update-status', 'uses' => 'AccountController@updateStatus']);
        Route::get('/create', ['as' => 'account.create', 'uses' => 'AccountController@create']);
        Route::post('/store', ['as' => 'account.store', 'uses' => 'AccountController@store']);
        Route::get('{id}/edit',   ['as' => 'account.edit', 'uses' => 'AccountController@edit']);
        Route::post('/update', ['as' => 'account.update', 'uses' => 'AccountController@update']);
        Route::get('{id}/destroy', ['as' => 'account.destroy', 'uses' => 'AccountController@destroy']);
    });   
});