<?php

use Illuminate\Support\Facades\Route;

    Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {
    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'SalesSetup'], function () {

        
        //Customer crud operation start
        Route::get('/sales-setup-customer-list', 'CustomerController@index')->name('salesSetup.customer.index');
        Route::get('/dataProcessingCustomer', 'CustomerController@dataProcessingCustomer')->name('salesSetup.customer.dataProcessingCustomer');
        Route::get('/sales-setup-customer-default-list', 'CustomerController@customerList')->name('salesSetup.customer.customer.list');
        Route::get('/sales-setup-customer-create', 'CustomerController@create')->name('salesSetup.customer.create');
        Route::post('/sales-setup-customer-store', 'CustomerController@store')->name('salesSetup.customer.store');
        Route::get('/sales-setup-customer-edit/{id}', 'CustomerController@edit')->name('salesSetup.customer.edit');
        Route::get('/sales-setup-customer-store-ajax', 'CustomerController@loadModal')->name('salesSetup.customer.store.ajax');
        Route::post('/sales-setup-customer-store-ajax-save', 'CustomerController@ajaxSave')->name('salesSetup.customer.store.ajaxSave');
        Route::post('/sales-setup-customer-update/{id}', 'CustomerController@update')->name('salesSetup.customer.update');
        Route::get('/sales-setup-customer-delete/{id}', 'CustomerController@destroy')->name('salesSetup.customer.destroy');
        Route::get('/sales-setup-customer-status/{id}/{status}', 'CustomerController@statusUpdate')->name('salesSetup.customer.status');
        Route::post('/sales-setup-customer-import', 'CustomerController@customerImport')->name('salesSetup.customer.import');
        Route::get('/sales-setup-customer-explode', 'CustomerController@customerExplode')->name('salesSetup.customer.explode');
        //Customer crud operation end

        //Sales POS
        Route::get('/salespos', 'SalesController@salespos')->name('salespos');


        //Customer Group crud operation start
        Route::get('/sales-setup-customer-group-list', 'CustomerGroupController@index')->name('salesSetup.customerGroup.index');
        Route::get('/dataProcessingCustomerGroup', 'CustomerGroupController@dataProcessingCustomerGroup')->name('salesSetup.customerGroup.dataProcessingCustomerGroup');
        Route::get('/sales-setup-customer-group-create', 'CustomerGroupController@create')->name('salesSetup.customerGroup.create');
        Route::post('/sales-setup-customer-group-store', 'CustomerGroupController@store')->name('salesSetup.customerGroup.store');
        Route::get('/sales-setup-customer-group-edit/{id}', 'CustomerGroupController@edit')->name('salesSetup.customerGroup.edit');
        Route::get('/sales-setup-customer-group-store-ajax', 'CustomerGroupController@loadModal')->name('salesSetup.customerGroup.store.ajax');
        Route::post('/sales-setup-customer-group-store-ajax-save', 'CustomerGroupController@ajaxSave')->name('salesSetup.customerGroup.store.ajaxSave');
        Route::post('/sales-setup-customer-group-update/{id}', 'CustomerGroupController@update')->name('salesSetup.customerGroup.update');
        Route::get('/sales-setup-customer-group-delete/{id}', 'CustomerGroupController@destroy')->name('salesSetup.customerGroup.destroy');
        Route::get('/sales-setup-customer-group-status/{id}/{status}', 'CustomerGroupController@statusUpdate')->name('salesSetup.customerGroup.status');
        Route::post('/sales-setup-customer-group-import', 'CustomerGroupController@customerGroupImport')->name('salesSetup.customerGroup.import');
        Route::get('/sales-setup-customer-group-explode', 'CustomerGroupController@customerGroupExplode')->name('salesSetup.customerGroup.explode');
        //Customer Group crud operation end


        //Customer Media crud operation start
        Route::get('/sales-setup-customer-media-list', 'CustomerMediaController@index')->name('salesSetup.customerMedia.index');
        Route::get('/dataProcessingCustomerMedia', 'CustomerMediaController@dataProcessingCustomerMedia')->name('salesSetup.customerMedia.dataProcessingCustomerMedia');
        Route::get('/sales-setup-customer-media-create', 'CustomerMediaController@create')->name('salesSetup.customerMedia.create');
        Route::post('/sales-setup-customer-media-store', 'CustomerMediaController@store')->name('salesSetup.customerMedia.store');
        Route::get('/sales-setup-customer-media-edit/{id}', 'CustomerMediaController@edit')->name('salesSetup.customerMedia.edit');
        Route::post('/sales-setup-customer-media-update/{id}', 'CustomerMediaController@update')->name('salesSetup.customerMedia.update');
        Route::get('/sales-setup-customer-media-delete/{id}', 'CustomerMediaController@destroy')->name('salesSetup.customerMedia.destroy');
        Route::get('/sales-setup-customer-media-status/{id}/{status}', 'CustomerMediaController@statusUpdate')->name('salesSetup.customerMedia.status');
        //Customer Media crud operation end


        //sales Reference crud operation start
        Route::get('/sales-setup-sales-reference-list', 'SalesReferenceController@index')->name('salesSetup.salesReference.index');
        Route::get('/dataProcessingSalesReference', 'SalesReferenceController@dataProcessingSalesReference')->name('salesSetup.salesReference.dataProcessingSalesReference');
        Route::get('/sales-setup-sales-reference-create', 'SalesReferenceController@create')->name('salesSetup.salesReference.create');
        Route::post('/sales-setup-sales-reference-store', 'SalesReferenceController@store')->name('salesSetup.salesReference.store');
        Route::get('/sales-setup-sales-reference-edit/{id}', 'SalesReferenceController@edit')->name('salesSetup.salesReference.edit');
        Route::get('/sales-setup-sales-reference-show/{id}', 'SalesReferenceController@show')->name('salesSetup.salesReference.show');
        Route::post('/sales-setup-sales-reference-update/{id}', 'SalesReferenceController@update')->name('salesSetup.salesReference.update');
        Route::get('/sales-setup-sales-reference-delete/{id}', 'SalesReferenceController@destroy')->name('salesSetup.salesReference.destroy');
        Route::get('/sales-setup-sales-reference-status/{id}/{status}', 'SalesReferenceController@statusUpdate')->name('salesSetup.salesReference.status');
        Route::post('/sales-setup-sales-reference-import', 'SalesReferenceController@salesReferenceImport')->name('salesSetup.salesReference.import');
        Route::get('/sales-setup-sales-reference-explode', 'SalesReferenceController@salesReferenceExplode')->name('salesSetup.salesReference.explode');
        //sales Reference crud operation end
    });


        Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'SalesTransaction'], function () {
        //sales  crud operation start
        Route::get('/sales-transaction-sales-list', 'SalesController@index')->name('salesTransaction.sales.index');
        Route::get('/dataProcessingSales', 'SalesController@dataProcessingSales')->name('salesTransaction.sales.dataProcessingSales');
        Route::get('/sales-transaction-sales-create', 'SalesController@create')->name('salesTransaction.sales.create');
        Route::post('/sales-transaction-sales-store', 'SalesController@store')->name('salesTransaction.sales.store');
        Route::get('/sales-transaction-sales-edit/{id}', 'SalesController@edit')->name('salesTransaction.sales.edit');
        Route::get('/sales-transaction-sales-batch', 'SalesController@getBatch')->name('salesTransaction.sales.batch');
        Route::get('/sales-transaction-sales-batch-stock', 'SalesController@getBatchStock')->name('salesTransaction.sales.batch.stock');
        Route::get('/sales-transaction-sales-show/{id}', 'SalesController@show')->name('salesTransaction.sales.show');
        Route::get('/sales-transaction-sales-account-approved/{sales_id}/{status}', 'SalesController@accountApproved')->name('salesTransaction.sales.accountApproved');
        Route::post('/sales-transaction-sales-update/{id}', 'SalesController@update')->name('salesTransaction.sales.update');
        Route::get('/sales-transaction-sales-delete/{id}', 'SalesController@destroy')->name('salesTransaction.sales.destroy');
        Route::get('/sales-transaction-sales-status/{id}/{status}', 'SalesController@statusUpdate')->name('salesTransaction.sales.status');
        Route::get('/sales-transaction-sales-detailsInfo', 'SalesController@detailsInfo')->name('salesTransaction.sales.detailsInfo');
        Route::get('/sales-transaction-sales-details-create', 'SalesController@create')->name('salesTransaction.sales.details.create');

        //sales  crud operation end

        //sales loan crud operation start
        Route::get('/sales-transaction-sales-loan-list', 'SalesLoanController@index')->name('salesTransaction.salesLoan.index');
        Route::get('/dataProcessingSalesLoan', 'SalesLoanController@dataProcessingSalesLoan')->name('salesTransaction.salesLoan.dataProcessingSalesLoan');
        Route::get('/sales-transaction-sales-loan-create', 'SalesLoanController@create')->name('salesTransaction.salesLoan.create');
        Route::post('/sales-transaction-sales-loan-store', 'SalesLoanController@store')->name('salesTransaction.salesLoan.store');
        Route::get('/sales-transaction-sales-loan-edit/{id}', 'SalesLoanController@edit')->name('salesTransaction.salesLoan.edit');
        Route::get('/sales-transaction-sales-loan-batch', 'SalesLoanController@getBatch')->name('salesTransaction.salesLoan.batch');
        Route::get('/sales-transaction-sales-loan-batch-stock', 'SalesLoanController@getBatchStock')->name('salesTransaction.salesLoan.batch.stock');
        Route::get('/sales-transaction-sales-loan-show/{id}', 'SalesLoanController@show')->name('salesTransaction.salesLoan.show');
        Route::post('/sales-transaction-sales-loan-update/{id}', 'SalesLoanController@update')->name('salesTransaction.salesLoan.update');
        Route::get('/sales-transaction-sales-loan-delete/{id}', 'SalesLoanController@destroy')->name('salesTransaction.salesLoan.destroy');
        Route::get('/sales-transaction-sales-loan-status/{id}/{status}', 'SalesLoanController@statusUpdate')->name('salesTransaction.salesLoan.status');
        Route::get('/sales-transaction-sales-loan-detailsInfo', 'SalesLoanController@detailsInfo')->name('salesTransaction.salesLoan.detailsInfo');
        Route::get('/sales-transaction-sales-loan-details-create', 'SalesLoanController@create')->name('salesTransaction.salesLoan.details.create');
        //sales loan crud operation end


        //sales  return operation start
        Route::get('/sales-transaction-sales-return-list', 'SalesReturnController@index')->name('salesTransaction.salesReturn.index');
        Route::get('/dataProcessingSalesReturn', 'SalesReturnController@dataProcessingSalesReturn')->name('salesTransaction.salesReturn.dataProcessingSalesReturn');
        Route::get('/sales-transaction-sales-return-create', 'SalesReturnController@create')->name('salesTransaction.salesReturn.create');
        Route::post('/sales-transaction-sales-return-store', 'SalesReturnController@store')->name('salesTransaction.salesReturn.store');
        Route::get('/sales-transaction-sales-return-edit/{id}', 'SalesReturnController@edit')->name('salesTransaction.salesReturn.edit');
        Route::get('/sales-transaction-sales-list-autocomplete', 'SalesReturnController@salesListAutocomplete')->name('salesTransaction.salesReturn.autocomplete');
        Route::get('/sales-transaction-sales-details', 'SalesReturnController@salesDetails')->name('salesTransaction.sales.details');
        Route::get('/sales-transaction-sales-return-show/{id}', 'SalesReturnController@show')->name('salesTransaction.salesReturn.show');
        Route::post('/sales-transaction-sales-return-update/{id}', 'SalesReturnController@update')->name('salesTransaction.salesReturn.update');
        Route::get('/sales-transaction-sales-return-delete/{id}', 'SalesReturnController@destroy')->name('salesTransaction.salesReturn.destroy');
        Route::get('/sales-transaction-sales-return-status/{id}/{status}', 'SalesReturnController@statusUpdate')->name('salesTransaction.salesReturn.status');
        Route::get('/sales-transaction-sales-return-detailsInfo', 'SalesReturnController@detailsInfo')->name('salesTransaction.salesReturn.detailsInfo');
        Route::get('/sales-transaction-sales-return-approved/{id}/{status}', 'SalesReturnController@approved')->name('salesTransaction.salesReturn.approved');

        //sales return Details crud operation 
        Route::get('/sales-transaction-sales-return-details-create', 'SalesReturnController@create')->name('salesTransaction.salesReturn.details.create');
        //sales return Details crud operation end
        
        //sales loan return operation start
        Route::get('/sales-transaction-sales-loan-return-list', 'SalesLoanReturnController@index')->name('salesTransaction.salesLoanReturn.index');
        Route::get('/dataProcessingSalesLoanReturn', 'SalesLoanReturnController@dataProcessingSalesLoanReturn')->name('salesTransaction.salesLoanReturn.dataProcessingSalesLoanReturn');
        Route::get('/sales-transaction-sales-loan-return-create', 'SalesLoanReturnController@create')->name('salesTransaction.salesLoanReturn.create');
        Route::post('/sales-transaction-sales-loan-return-store', 'SalesLoanReturnController@store')->name('salesTransaction.salesLoanReturn.store');
        Route::get('/sales-transaction-sales-loan-return-edit/{id}', 'SalesLoanReturnController@edit')->name('salesTransaction.salesLoanReturn.edit');
        Route::get('/sales-transaction-sales-loan-list-autocomplete', 'SalesLoanReturnController@salesLoanListAutocomplete')->name('salesTransaction.salesLoanReturn.autocomplete');
        Route::get('/sales-transaction-sales-loan-details', 'SalesLoanReturnController@salesLoanDetails')->name('salesTransaction.salesLoan.details');
        Route::get('/sales-transaction-sales-loan-return-show/{id}', 'SalesLoanReturnController@show')->name('salesTransaction.salesLoanReturn.show');
        Route::post('/sales-transaction-sales-loan-return-update/{id}', 'SalesLoanReturnController@update')->name('salesTransaction.salesLoanReturn.update');
        Route::get('/sales-transaction-sales-loan-return-delete/{id}', 'SalesLoanReturnController@destroy')->name('salesTransaction.salesLoanReturn.destroy');
        Route::get('/sales-transaction-sales-loan-return-status/{id}/{status}', 'SalesLoanReturnController@statusUpdate')->name('salesTransaction.salesLoanReturn.status');
        Route::get('/sales-transaction-sales-loan-return-detailsInfo', 'SalesLoanReturnController@detailsInfo')->name('salesTransaction.salesLoanReturn.detailsInfo');

        //sales loan return Details crud operation 
        Route::get('/sales-transaction-sales-loan-return-details-create', 'SalesLoanReturnController@create')->name('salesTransaction.salesLoanReturn.details.create');
        //sales loan return Details crud operation end


         //sales Quatation crud operation start
         Route::get('/sales-transaction-sales-quatation-list', 'SalesQuatationController@index')->name('salesTransaction.salesQuatation.index');
         Route::get('/dataProcessingSalesQuatation', 'SalesQuatationController@dataProcessingSalesQuatation')->name('salesTransaction.salesQuatation.dataProcessingSalesQuatation');
         Route::get('/sales-transaction-sales-quatation-create', 'SalesQuatationController@create')->name('salesTransaction.salesQuatation.create');
         Route::post('/sales-transaction-sales-quatation-store', 'SalesQuatationController@store')->name('salesTransaction.salesQuatation.store');
         Route::get('/sales-transaction-sales-quatation-edit/{id}', 'SalesQuatationController@edit')->name('salesTransaction.salesQuatation.edit');
         Route::get('/sales-transaction-sales-quatation-show/{id}', 'SalesQuatationController@show')->name('salesTransaction.salesQuatation.show');
         Route::post('/sales-transaction-sales-quatation-update/{id}', 'SalesQuatationController@update')->name('salesTransaction.salesQuatation.update');
         Route::get('/sales-transaction-sales-quatation-delete/{id}', 'SalesQuatationController@destroy')->name('salesTransaction.salesQuatation.destroy');
         Route::get('/sales-transaction-sales-quatation-status/{id}/{status}', 'SalesQuatationController@statusUpdate')->name('salesTransaction.salesQuatation.status');
         Route::get('/sales-transaction-sales-quatation-detailsInfo', 'SalesQuatationController@detailsInfo')->name('salesTransaction.salesQuatation.detailsInfo');
         Route::get('/sales-transaction-sales-quatation-approved/{sales_quatation_id}/{status}', 'SalesQuatationController@approved')->name('salesTransaction.salesQuatation.approved');

         //sales Quatation crud operation end
 
         //sales Quatation Details crud operation 
         Route::get('/sales-transaction-sales-quatation-details-create', 'SalesQuatationController@create')->name('salesTransaction.salesQuatation.details.create');
         //sales Quatation Details crud operation end

        //deliveryChallan  crud operation start
        Route::get('/sales-transaction-deliveryChallan-list', 'DeliveryChallanController@index')->name('salesTransaction.deliveryChallan.index');
        Route::get('/dataProcessingDeliveryChallan', 'DeliveryChallanController@dataProcessingDeliveryChallan')->name('salesTransaction.deliveryChallan.dataProcessingDeliveryChallan');
        Route::get('/sales-transaction-deliveryChallan-create', 'DeliveryChallanController@create')->name('salesTransaction.deliveryChallan.create');
        Route::post('/sales-transaction-deliveryChallan-store', 'DeliveryChallanController@store')->name('salesTransaction.deliveryChallan.store');
        Route::get('/sales-transaction-deliveryChallan-edit/{id}', 'DeliveryChallanController@edit')->name('salesTransaction.deliveryChallan.edit');
        Route::get('/sales-transaction-deliveryChallan-show/{id}', 'DeliveryChallanController@show')->name('salesTransaction.deliveryChallan.show');
        Route::post('/sales-transaction-deliveryChallan-update/{id}', 'DeliveryChallanController@update')->name('salesTransaction.deliveryChallan.update');
        Route::get('/sales-transaction-deliveryChallan-delete/{id}', 'DeliveryChallanController@destroy')->name('salesTransaction.deliveryChallan.destroy');
        Route::get('/sales-transaction-deliveryChallan-status/{id}/{status}', 'DeliveryChallanController@statusUpdate')->name('salesTransaction.deliveryChallan.status');

        //deliveryChallan crud operation end

        //deliveryChallan Details crud operation 
        Route::get('/sales-transaction-deliveryChallan-details-create', 'DeliveryChallanController@create')->name('salesTransaction.deliveryChallan.details.create');
        //deliveryChallan Details crud operation end  



        //due sale  crud operation start
        Route::get('/sales-transaction-sale-payment-list', 'SalesPaymentController@index')->name('salesTransaction.salePayment.index');
        Route::get('/dataProcessingSalePayment', 'SalesPaymentController@dataProcessingSalePayment')->name('salesTransaction.salePayment.dataProcessingSalePayment');
        Route::get('/sales-transaction-sale-payment-create', 'SalesPaymentController@create')->name('salesTransaction.salePayment.create');
        Route::post('/sales-transaction-sale-payment-store', 'SalesPaymentController@store')->name('salesTransaction.salePayment.store');
        Route::get('/sales-transaction-sale-due-voucher-list', 'SalesPaymentController@customerDueVoucherList')->name('salesTransaction.salePayment.dueVoucherList');
        Route::get('/sales-transaction-sale-payment-show/{id}', 'SalesPaymentController@show')->name('salesTransaction.salePayment.show');
        //due sale  crud operation end
 

         //sale pending check Approved  crud operation start
         Route::get('/sales-transaction-sale-pending-cheque-list', 'SalesPendingChequeController@index')->name('salesTransaction.sales.pendingCheque.index');
         Route::get('/dataProcessingSalePendingCheque', 'SalesPendingChequeController@dataProcessingSalePendingCheque')->name('salesTransaction.sales.pendingCheque.dataProcessingSalePendingCheque');
         Route::get('//sales-transaction-sales-pending-cheque-create', 'SalesPendingChequeController@create')->name('salesTransaction.sales.pendingCheque.create');
         Route::post('/sales-transaction-sale-pending-cheque-store', 'SalesPendingChequeController@store')->name('salesTransaction.sales.pendingCheque.store');
         Route::get('/sales-transaction-sale-pending-cheque-approved/{id}/{status}', 'SalesPendingChequeController@salesPendingChequeApproved')->name('salesTransaction.sales.pendingCheque.approved');
         Route::get('/sales-transaction-sale-pending-cheque-show/{id}', 'SalesPendingChequeController@show')->name('salesTransaction.sales.pendingCheque.show');
         //sale pending check Approved  crud operation end

    });

    
    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'SalesReport'], function () {
        //sales report crud operation start
        Route::any('/sales-report-customer-ledger', 'SalesReport@customerLedger')->name('salesReport.salesLedger');
        Route::any('/sales-report-stock-summary', 'SalesStockReport@saleLedger')->name('salesReport.saleStockLedger');
        Route::any('/sales-report-date-and-customer-wise', 'SalesReport@salesReport')->name('salesReport.dateAndCustomerWise');
        Route::any('/sales-report-product-ledger', 'SalesReport@productLedger')->name('salesReport.productLedger');
        Route::any('/sales-report-transfer-report', 'SalesReport@transferReport')->name('salesReport.transferReport');
        //sales report crud operation start

    });


});
