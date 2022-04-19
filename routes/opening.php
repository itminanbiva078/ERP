<?php

use Illuminate\Support\Facades\Route;

    Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {
    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Opening'], function () {

        //customer opening crud operation start
        Route::get('/opening-setup-customer-opening-list', 'CustomerOpeningController@index')->name('openingSetup.customerOpening.index');
        Route::get('/dataProcessingCustomerOpening', 'CustomerOpeningController@dataProcessingCustomerOpening')->name('openingSetup.customerOpening.dataProcessingCustomerOpening');
        Route::get('/opening-setup-customer-opening-create', 'CustomerOpeningController@create')->name('openingSetup.customerOpening.create');
        Route::post('/opening-setup-customer-opening-store', 'CustomerOpeningController@store')->name('openingSetup.customerOpening.store');
        Route::get('/opening-setup-customer-opening-show/{id}', 'CustomerOpeningController@show')->name('openingSetup.customerOpening.show');
        Route::get('/opening-setup-customer-opening-edit/{id}', 'CustomerOpeningController@edit')->name('openingSetup.customerOpening.edit');
        Route::post('/opening-setup-customer-opening-update/{id}', 'CustomerOpeningController@update')->name('openingSetup.customerOpening.update');
        Route::get('/opening-setup-customer-opening-delete/{id}', 'CustomerOpeningController@destroy')->name('openingSetup.customerOpening.destroy');
        Route::get('/opening-setup-customer-opening-status/{id}/{status}', 'CustomerOpeningController@statusUpdate')->name('openingSetup.customerOpening.status');
        //customer opening crud operation end

        //customer opening details crud operation start
        Route::get('/opening-setup-customer-opening-details-create', 'CustomerOpeningController@create')->name('openingSetup.customerOpening.details.create');
        //customer opening details  crud operation end

        //supplier opening crud operation start
        Route::get('/opening-setup-supplier-opening-list', 'SupplierOpeningController@index')->name('openingSetup.supplierOpening.index');
        Route::get('/dataProcessingSupplierOpening', 'SupplierOpeningController@dataProcessingSupplierOpening')->name('openingSetup.supplierOpening.dataProcessingSupplierOpening');
        Route::get('/opening-setup-supplier-opening-create', 'SupplierOpeningController@create')->name('openingSetup.supplierOpening.create');
        Route::post('/opening-setup-supplier-opening-store', 'SupplierOpeningController@store')->name('openingSetup.supplierOpening.store');
        Route::get('/opening-setup-supplier-opening-show/{id}', 'SupplierOpeningController@show')->name('openingSetup.supplierOpening.show');

        Route::get('/opening-setup-supplier-opening-edit/{id}', 'SupplierOpeningController@edit')->name('openingSetup.supplierOpening.edit');
        Route::post('/opening-setup-supplier-opening-update/{id}', 'SupplierOpeningController@update')->name('openingSetup.supplierOpening.update');
        Route::get('/opening-setup-supplier-opening-delete/{id}', 'SupplierOpeningController@destroy')->name('openingSetup.supplierOpening.destroy');
        Route::get('/opening-setup-supplier-opening-status/{id}/{status}', 'SupplierOpeningController@statusUpdate')->name('openingSetup.supplierOpening.status');
        //supplier opening  crud operation end

        //supplier opening details crud operation start
        Route::get('/opening-setup-supplier-opening-details-create', 'SupplierOpeningController@create')->name('openingSetup.supplierOpening.details.create');
        //supplier opening details  crud operation end

        //inventory crud operation start
        Route::get('/opening-setup-inventory-list', 'InventoryOpeningController@index')->name('openingSetup.inventory.index');
        Route::get('/dataProcessingInventoryOpening', 'InventoryOpeningController@dataProcessingInventoryOpening')->name('openingSetup.Inventory.dataProcessingInventory');
        Route::get('/opening-setup-inventory-create', 'InventoryOpeningController@create')->name('openingSetup.inventory.create');
        Route::post('/opening-setup-inventory-store', 'InventoryOpeningController@store')->name('openingSetup.inventory.store');
        Route::get('/opening-setup-inventory-edit/{id}', 'InventoryOpeningController@edit')->name('openingSetup.inventory.edit');
        Route::post('/opening-setup-inventory-update/{id}', 'InventoryOpeningController@update')->name('openingSetup.inventory.update');
        Route::get('/opening-setup-inventory-delete/{id}', 'InventoryOpeningController@destroy')->name('openingSetup.inventory.destroy');
        Route::get('/opening-setup-inventory-show/{id}', 'InventoryOpeningController@show')->name('openingSetup.inventory.show');
        Route::get('/opening-setup-inventory-status/{id}/{status}', 'InventoryOpeningController@statusUpdate')->name('openingSetup.inventory.status');
        Route::post('/opening-setup-inventory-import', 'InventoryOpeningController@inventoryImport')->name('openingSetup.inventory.import');
        Route::get('/opening-setup-inventory-explode', 'InventoryOpeningController@inventoryGroupExplode')->name('openingSetup.inventory.explode');
        //inventory  crud operation end

        //inventory  crud operation end
        Route::get('/opening-setup-inventory-details-create', 'InventoryOpeningController@create')->name('openingSetup.inventory.details.create');
       //inventory  crud operation end

    });

   
     

});
