<?php

use Illuminate\Support\Facades\Route;

    Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {
    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'ServiceSetup'], function () {

        //service crud operation start
        Route::get('/service-setup-service-list', 'ServiceController@index')->name('serviceSetup.service.index');
        Route::get('/dataProcessingService', 'ServiceController@dataProcessingService')->name('serviceSetup.service.dataProcessingService');
        Route::get('/service-setup-service-create', 'ServiceController@create')->name('serviceSetup.service.create');
        Route::post('/service-setup-service-store', 'ServiceController@store')->name('serviceSetup.service.store');
        Route::get('/service-setup-service-edit/{id}', 'ServiceController@edit')->name('serviceSetup.service.edit');
        Route::post('/service-setup-service-update/{id}', 'ServiceController@update')->name('serviceSetup.service.update');
        Route::get('/service-setup-service-delete/{id}', 'ServiceController@destroy')->name('serviceSetup.service.destroy');
        Route::get('/service-setup-service-status/{id}/{status}', 'ServiceController@statusUpdate')->name('serviceSetup.service.status');
        Route::post('/service-setup-service-import', 'ServiceController@serviceImport')->name('serviceSetup.service.import');
        Route::get('/service-setup-service-explode', 'ServiceController@serviceExplode')->name('serviceSetup.service.explode');
        //service crud operation end

        //service category crud operation start
        Route::get('/service-setup-service-category-list', 'ServiceCategoryController@index')->name('serviceSetup.serviceCategory.index');
        Route::get('/dataProcessingServiceCategory', 'ServiceCategoryController@dataProcessingServiceCategory')->name('serviceSetup.serviceCategory.dataProcessingServiceCategory');
        Route::get('/service-setup-service-category-create', 'ServiceCategoryController@create')->name('serviceSetup.serviceCategory.create');
        Route::post('/service-setup-service-category-store', 'ServiceCategoryController@store')->name('serviceSetup.serviceCategory.store');
        Route::get('/service-setup-service-category-edit/{id}', 'ServiceCategoryController@edit')->name('serviceSetup.serviceCategory.edit');
        Route::post('/service-setup-service-category-update/{id}', 'ServiceCategoryController@update')->name('serviceSetup.serviceCategory.update');
        Route::get('/service-setup-service-category-delete/{id}', 'ServiceCategoryController@destroy')->name('serviceSetup.serviceCategory.destroy');
        Route::get('/service-setup-service-category-status/{id}/{status}', 'ServiceCategoryController@statusUpdate')->name('serviceSetup.serviceCategory.status');
        Route::post('/service-setup-service-category-import', 'ServiceCategoryController@serviceCategoryImport')->name('serviceSetup.serviceCategory.import');
        Route::get('/service-setup-service-category-explode', 'ServiceCategoryController@serviceCategoryGroupExplode')->name('serviceSetup.serviceCategory.explode');
        //service category crud operation end


    });

    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'ServiceTransaction'], function () {

        //service invoice crud operation start
        Route::get('/service-setup-service-invoice-list', 'ServiceInvoiceController@index')->name('serviceTransaction.serviceInvoice.index');
        Route::get('/dataProcessingServiceInvoice', 'ServiceInvoiceController@dataProcessingServiceInvoice')->name('serviceTransaction.serviceInvoice.dataProcessingServiceInvoice');
        Route::get('/service-setup-service-invoice-create', 'ServiceInvoiceController@create')->name('serviceTransaction.serviceInvoice.create');
        Route::post('/service-setup-service-invoice-store', 'ServiceInvoiceController@store')->name('serviceTransaction.serviceInvoice.store');
        Route::get('/service-setup-service-invoice-edit/{id}', 'ServiceInvoiceController@edit')->name('serviceTransaction.serviceInvoice.edit');
        Route::get('/service-setup-service-show/{id}', 'ServiceInvoiceController@show')->name('serviceTransaction.serviceInvoice.show');
        Route::post('/service-setup-service-invoice-update/{id}', 'ServiceInvoiceController@update')->name('serviceTransaction.serviceInvoice.update');
        Route::get('/service-setup-service-invoice-delete/{id}', 'ServiceInvoiceController@destroy')->name('serviceTransaction.serviceInvoice.destroy');
        Route::get('/service-setup-service-account-approved/{service_invoice_id}/{status}', 'ServiceInvoiceController@approved')->name('serviceTransaction.serviceInvoice.approved');

        //service invoice crud operation end

        //service invoice Details crud operation 
        Route::get('/service-setup-service-invoice-details-create', 'ServiceInvoiceController@create')->name('serviceTransaction.serviceInvoice.create');
        //service invoice Details crud operation end

         //service Quatation crud operation start
         Route::get('/service-transaction-service-quatation-list', 'ServiceQuatationController@index')->name('serviceTransaction.serviceQuatation.index');
         Route::get('/dataProcessingServiceQuatation', 'ServiceQuatationController@dataProcessingServiceQuatation')->name('serviceTransaction.serviceQuatation.dataProcessingServiceQuatation');
         Route::get('/service-transaction-service-quatation-create', 'ServiceQuatationController@create')->name('serviceTransaction.serviceQuatation.create');
         Route::post('/service-transaction-service-quatation-store', 'ServiceQuatationController@store')->name('serviceTransaction.serviceQuatation.store');
         Route::get('/service-transaction-service-quatation-edit/{id}', 'ServiceQuatationController@edit')->name('serviceTransaction.serviceQuatation.edit');
         Route::get('/service-transaction-service-quatation-show/{id}', 'ServiceQuatationController@show')->name('serviceTransaction.serviceQuatation.show');
         Route::post('/service-transaction-service-quatation-update/{id}', 'ServiceQuatationController@update')->name('serviceTransaction.serviceQuatation.update');
         Route::get('/service-transaction-service-quatation-delete/{id}', 'ServiceQuatationController@destroy')->name('serviceTransaction.serviceQuatation.destroy');
         Route::get('/service-transaction-service-quatation-status/{id}/{status}', 'ServiceQuatationController@statusUpdate')->name('serviceTransaction.serviceQuatation.status');
         Route::get('/service-transaction-service-quatation-detailsInfo', 'ServiceQuatationController@detailsInfo')->name('serviceTransaction.serviceQuatation.detailsInfo');
         Route::get('/service-transaction-service-quatation-approved/{service_quatation_id}/{status}', 'ServiceQuatationController@approved')->name('serviceTransaction.serviceQuatation.approved');

         //service Quatation crud operation end
 
         //service Quatation Details crud operation 
         Route::get('/service-transaction-service-quatation-details-create', 'ServiceQuatationController@create')->name('serviceTransaction.serviceQuatation.create');
         //service Quatation Details crud operation end

    });
     

});
