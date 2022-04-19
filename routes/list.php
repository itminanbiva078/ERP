<?php

use Illuminate\Support\Facades\Route;

    Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {
    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'PendingCheck'], function () {

        //PendingCheck crud operation start

        Route::get('/pendind-check-list', 'PendingCheckController@index')->name('pendingCheck.pendingCheck.index');
        
        //PendingCheck crud operation end
    });

    
});
