<?php

use Illuminate\Support\Facades\Route;

    Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {
    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Pos'], function () {
        //pos crud operation start
        Route::get('/pos-list', 'PosController@index')->name('pos.pos.index');
        Route::get('/dataProcessingPos', 'PosController@dataProcessingPos')->name('pos.pos.dataProcessingPos');
        Route::get('/pos-create', 'PosController@create')->name('pos.pos.create');
        Route::get('/pos-product-filter-by-category-or-name', 'PosController@productFilter')->name('pos.product.filter');
        Route::get('/pos-product-filter-by-details', 'PosController@productDetails')->name('pos.product.details');
        Route::post('/pos-transaction-pos-store', 'PosController@store')->name('pos.transaction.pos.store');
        Route::get('/pos-status/{id}/{status}', 'PosController@statusUpdate')->name('pos.pos.status');
        Route::get('/pos-show/{id}', 'PosController@show')->name('pos.pos.show');

        Route::get('/pos-delete/{id}', 'PosController@destroy')->name('pos.pos.destroy');


        //pos crud operation end
    });


});
