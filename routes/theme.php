<?php

use Illuminate\Support\Facades\Route;

    Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {
        
       /*media galar crud start*/
        Route::get('theme-appearance-media-list', 'Media@index')->name('theme.appearance.media');
        Route::post('theme-appearance-media-upload', 'Media@upload')->name('theme.appearance.media_upload');
        Route::post('theme-appearance-media-delete', 'Media@delete');
        Route::post('theme-appearance-media-update', 'Media@update');
        Route::get('theme-appearance-media-download/{id}', 'Media@download');
        Route::get('theme-appearance-media-get-media/{offset}', 'Media@getMedias');
        Route::get('theme-appearance-media_search', 'Media@media_search')->name('theme.appearance.media_search');
         /*media galar crud end*/
    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Theme'], function () {
      /*sm theme  crud start*/
        Route::any('/theme-appearance-edit', 'AppearanceController@editor')->name('theme.appearance.edit');
        Route::post("/theme-appearance-edit-save", "AppearanceController@saveEditor")->name('theme.appearance.edit.save');
        Route::get("theme-appearance-theme-option", "AppearanceController@themeOptions")->name('theme.appearance.theme.option');
        Route::post("save-sm-theme-options", "AppearanceController@saveSmThemeOptions")->name("theme.appearance.saveThemeOption");
          /*sm theme crud start*/

      // contact crud start
        Route::get('/theme-appearance-website-list', 'ContactController@index')->name('theme.appearance.website.index');
        Route::get('/dataProcessingContact', 'ContactController@dataProcessingContact')->name('theme.appearance.website.dataProcessingContact');
        Route::post('/theme-appearance-website-store', 'ContactController@store')->name('theme.appearance.website.store');
        Route::get('/theme-appearance-website-status/{id}/{status}', 'ContactController@statusUpdate')->name('theme.appearance.website.status');
        Route::get('/theme-appearance-website-delete/{id}', 'ContactController@destroy')->name('theme.appearance.website.destroy');
      // contact crud end

      // subscribe crud start
        Route::get('/theme-appearance-subscribe-list', 'SubscribeController@index')->name('theme.appearance.subscribe.index');
        Route::get('/dataProcessingSubscribe', 'SubscribeController@dataProcessingSubscribe')->name('theme.appearance.subscribe.dataProcessingSubscribe');
        Route::post('/theme-appearance-subscribe-store', 'SubscribeController@store')->name('theme.appearance.subscribe.store');
        Route::get('/theme-appearance-subscribe-delete/{id}', 'SubscribeController@destroy')->name('theme.appearance.subscribe.destroy');
      // subscribe crud end

    });
  

});