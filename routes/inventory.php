<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {
    // Inventory setup crud start
    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'InventorySetup'], function () {
        //category crud operation start
        Route::get('/inventory-setup-category-list', 'CategoryController@index')->name('inventorySetup.category.index');
        Route::get('/dataProcessingCategory', 'CategoryController@dataProcessingCategory')->name('inventorySetup.category.dataProcessingCategory');
        Route::get('/inventory-setup-category-create', 'CategoryController@create')->name('inventorySetup.category.create');
        Route::post('/inventory-setup-category-store', 'CategoryController@store')->name('inventorySetup.category.store');
        Route::get('/inventory-setup-category-store-ajax', 'CategoryController@loadModal')->name('inventorySetup.category.store.ajax');
        Route::post('/inventory-setup-category-store-ajax-save', 'CategoryController@ajaxSave')->name('inventorySetup.category.store.ajaxSave');
        Route::get('/inventory-setup-category-edit/{id}', 'CategoryController@edit')->name('inventorySetup.category.edit');
        Route::post('/inventory-setup-category-update/{id}', 'CategoryController@update')->name('inventorySetup.category.update');
        Route::get('/inventory-setup-category-delete/{id}', 'CategoryController@destroy')->name('inventorySetup.category.destroy');
        Route::get('/inventory-setup-category-status/{id}/{status}', 'CategoryController@statusUpdate')->name('inventorySetup.category.status');
        Route::post('/inventory-setup-category-import', 'CategoryController@categoryImport')->name('inventorySetup.category.import');
        Route::get('/inventory-setup-category-explode', 'CategoryController@categoryExplode')->name('inventorySetup.category.explode');
        //category crud operation end

        //Floor crud operation start
        Route::get('/inventory-setup-floor-list', 'FloorController@index')->name('inventorySetup.floor.index');
        Route::get('/dataProcessingFloor', 'FloorController@dataProcessingFloor')->name('inventorySetup.floor.dataProcessingFloor');
        Route::get('/inventory-setup-floor-create', 'FloorController@create')->name('inventorySetup.floor.create');
        Route::post('/inventory-setup-floor-store', 'FloorController@store')->name('inventorySetup.floor.store');
        Route::get('/inventory-setup-floor-store-ajax', 'FloorController@loadModal')->name('inventorySetup.floor.store.ajax');
        Route::post('/inventory-setup-floor-store-ajax-save', 'FloorController@ajaxSave')->name('inventorySetup.floor.store.ajaxSave');
        Route::get('/inventory-setup-floor-edit/{id}', 'FloorController@edit')->name('inventorySetup.floor.edit');
        Route::post('/inventory-setup-floor-update/{id}', 'FloorController@update')->name('inventorySetup.floor.update');
        Route::get('/inventory-setup-floor-delete/{id}', 'FloorController@destroy')->name('inventorySetup.floor.destroy');
        Route::get('/inventory-setup-floor-status/{id}/{status}', 'FloorController@statusUpdate')->name('inventorySetup.floor.status');
        Route::post('/inventory-setup-floor-import', 'FloorController@floorImport')->name('inventorySetup.floor.import');
        Route::get('/inventory-setup-floor-explode', 'FloorController@floorExplode')->name('inventorySetup.floor.explode');
        //Floor crud operation end

        //product crud operation start
        Route::get('/inventory-setup-product-list', 'ProductController@index')->name('inventorySetup.product.index');
        Route::get('/dataProcessingProduct', 'ProductController@dataProcessingProduct')->name('inventorySetup.product.dataProcessingProduct');
        Route::get('/inventory-setup-product-create', 'ProductController@create')->name('inventorySetup.product.create');
        Route::post('/inventory-setup-product-store', 'ProductController@store')->name('inventorySetup.product.store');
        Route::get('/inventory-setup-product-edit/{id}', 'ProductController@edit')->name('inventorySetup.product.edit');
        Route::get('/inventory-setup-product-show/{id}/{viewType?}', 'ProductController@show')->name('inventorySetup.product.show');
        Route::get('/inventory-setup-product-stock-info', 'ProductController@stockInfo')->name('inventorySetup.product.stockInfo');
        Route::get('/inventory-setup-product-single-info', 'ProductController@singleInfo')->name('inventorySetup.product.single.info');
        Route::post('/inventory-setup-product-update/{id}', 'ProductController@update')->name('inventorySetup.product.update');
        Route::get('/inventory-setup-product-delete/{id}', 'ProductController@destroy')->name('inventorySetup.product.destroy');
        Route::get('/inventory-setup-product-status/{id}/{status}', 'ProductController@statusUpdate')->name('inventorySetup.product.status');
        Route::post('/inventory-setup-product-name-suggestions', 'ProductController@productNameSuggestions')->name('inventorySetup.productName.suggestions');
        Route::post('/inventory-setup-product-import', 'ProductController@productImport')->name('inventorySetup.product.import');
        Route::get('/inventory-setup-product-explode', 'ProductController@productExplode')->name('inventorySetup.product.explode');
        Route::post('/inventory-setup-upload-product', 'ProductController@uploadProduct')->name('inventorySetup.product.uploadProduct');
        Route::post('/inventory-setup-product-stock', 'ProductController@productStock')->name('inventorySetup.product.productStock');
        //product crud operation end

        //ProductDetailsController crud operation start
        Route::get('/inventory-setup-productDetails-list', 'ProductDetailsController@index')->name('inventorySetup.productDetails.index');
        Route::get('/dataProcessingProductDetails', 'ProductDetailsController@dataProcessingProduct')->name('inventorySetup.productDetails.dataProcessingProductDetails');
        Route::get('/inventory-setup-productDetails-create', 'ProductDetailsController@create')->name('inventorySetup.productDetails.create');
        Route::post('/inventory-setup-productDetails-store', 'ProductDetailsController@store')->name('inventorySetup.productDetails.store');
        Route::get('/inventory-setup-productDetails-edit/{id}', 'ProductDetailsController@edit')->name('inventorySetup.productDetails.edit');
        Route::post('/inventory-setup-productDetails-update/{id}', 'ProductDetailsController@update')->name('inventorySetup.productDetails.update');
        Route::get('/inventory-setup-productDetails-delete/{id}', 'ProductDetailsController@destroy')->name('inventorySetup.productDetails.destroy');
        Route::get('/inventory-setup-productDetails-status/{id}/{status}', 'ProductDetailsController@statusUpdate')->name('inventorySetup.productDetails.status');
        Route::post('/inventory-setup-productDetails-name-suggestions', 'ProductDetailsController@productDetailsNameSuggestions')->name('inventorySetup.productDetailsName.suggestions');
        Route::post('/inventory-setup-productDetails-import', 'ProductDetailsController@productDetailsImport')->name('inventorySetup.productDetails.import');
        Route::get('/inventory-setup-productDetails-explode', 'ProductDetailsController@productDetailsExplode')->name('inventorySetup.productDetails.explode');
        //product crud operation end

        //unit  crud operation start
        Route::get('/inventory-setup-unit-list', 'UnitController@index')->name('inventorySetup.unit.index');
        Route::get('/dataProcessingUnit', 'UnitController@dataProcessingUnit')->name('inventorySetup.unit.dataProcessingUnit');
        Route::get('/inventory-setup-unit-create', 'UnitController@create')->name('inventorySetup.unit.create');
        Route::post('/inventory-setup-unit-store', 'UnitController@store')->name('inventorySetup.unit.store');
        Route::get('/inventory-setup-unit-store-ajax', 'UnitController@loadModal')->name('inventorySetup.unit.store.ajax');
        Route::post('/inventory-setup-unit-store-ajax-save', 'UnitController@ajaxSave')->name('inventorySetup.unit.store.ajaxSave');
        Route::get('/inventory-setup-unit-edit/{id}', 'UnitController@edit')->name('inventorySetup.unit.edit');
        Route::post('/inventory-setup-unit-update/{id}', 'UnitController@update')->name('inventorySetup.unit.update');
        Route::get('/inventory-setup-unit-delete/{id}', 'UnitController@destroy')->name('inventorySetup.unit.destroy');
        Route::get('/inventory-setup-unit-status/{id}/{status}', 'UnitController@statusUpdate')->name('inventorySetup.unit.status');
        Route::post('/inventory-setup-unit-import', 'UnitController@unitImport')->name('inventorySetup.unit.import');
        Route::get('/inventory-setup-unit-explode', 'UnitController@unitExplode')->name('inventorySetup.unit.explode');
        //unit  crud operation end

        //brand  crud operation start
        Route::get('/inventory-setup-brand-list', 'BrandController@index')->name('inventorySetup.brand.index');
        Route::get('/dataProcessingBrand', 'BrandController@dataProcessingBrand')->name('inventorySetup.brand.dataProcessingBrand');
        Route::get('/inventory-setup-brand-create', 'BrandController@create')->name('inventorySetup.brand.create');
        Route::post('/inventory-setup-brand-store', 'BrandController@store')->name('inventorySetup.brand.store');
        Route::get('/inventory-setup-brand-store-ajax', 'BrandController@loadModal')->name('inventorySetup.brand.store.ajax');
        Route::post('/inventory-setup-brand-store-ajax-save', 'BrandController@ajaxSave')->name('inventorySetup.brand.store.ajaxSave');
        Route::get('/inventory-setup-brand-edit/{id}', 'BrandController@edit')->name('inventorySetup.brand.edit');
        Route::post('/inventory-setup-brand-update/{id}', 'BrandController@update')->name('inventorySetup.brand.update');
        Route::get('/inventory-setup-brand-delete/{id}', 'BrandController@destroy')->name('inventorySetup.brand.destroy');
        Route::get('/inventory-setup-brand-status/{id}/{status}', 'BrandController@statusUpdate')->name('inventorySetup.brand.status');
        Route::post('/inventory-setup-brand-import', 'BrandController@brandimport')->name('inventorySetup.brand.import');
        Route::get('/inventory-setup-brand-explode', 'BrandController@brandExplode')->name('inventorySetup.brand.explode');

        //this route common for all import load form
        Route::get('/inventory-setup-load-import-form', 'BrandController@loadImportForm')->name('inventorySetup.load.import.form');
         //this route common for all import load form
        


        //Product Review  crud operation start

        Route::get('/inventory-setup-product-review-list', 'ProductReviewController@index')->name('inventorySetup.productReview.index');
        Route::get('/dataProcessingProductReview', 'ProductReviewController@dataProcessingProductReview')->name('inventorySetup.productReview.dataProcessingProductReview');
        Route::get('/inventory-setup-product-review-delete/{id}', 'ProductReviewController@destroy')->name('inventorySetup.productReview.destroy');

        Route::get('/inventory-setup-product-review-status/{id}/{status}', 'ProductReviewController@statusUpdate')->name('inventorySetup.productReview.status');

        //Product Review  crud operation  end

        //warranty  crud operation start
        Route::get('/inventory-setup-warranty-list', 'WarrantyController@index')->name('inventorySetup.warranty.index');
        Route::get('/dataProcessingWarranty', 'WarrantyController@dataProcessingWarranty')->name('inventorySetup.warranty.dataProcessingWarranty');
        Route::get('/inventory-setup-warranty-create', 'WarrantyController@create')->name('inventorySetup.warranty.create');
        Route::post('/inventory-setup-warranty-store', 'WarrantyController@store')->name('inventorySetup.warranty.store');
        Route::get('/inventory-setup-warranty-edit/{id}', 'WarrantyController@edit')->name('inventorySetup.warranty.edit');
        Route::post('/inventory-setup-warranty-update/{id}', 'WarrantyController@update')->name('inventorySetup.warranty.update');
        Route::get('/inventory-setup-warranty-delete/{id}', 'WarrantyController@destroy')->name('inventorySetup.warranty.destroy');
        Route::get('/inventory-setup-warranty-status/{id}/{status}', 'WarrantyController@statusUpdate')->name('inventorySetup.warranty.status');
        //warranty  crud operation end

        //Supplier  crud operation start
        Route::get('/inventory-setup-supplier-list', 'SupplierController@index')->name('inventorySetup.supplier.index');
        Route::get('/dataProcessingSupplier', 'SupplierController@dataProcessingSupplier')->name('inventorySetup.supplier.dataProcessingSupplier');
        Route::get('/inventory-setup-supplier-create', 'SupplierController@create')->name('inventorySetup.supplier.create');
        Route::post('/inventory-setup-supplier-store', 'SupplierController@store')->name('inventorySetup.supplier.store');
        Route::get('/inventory-setup-supplier-store-ajax', 'SupplierController@loadModal')->name('inventorySetup.supplier.store.ajax');
        Route::post('/inventory-setup-supplier-store-ajax-save', 'SupplierController@ajaxSave')->name('inventorySetup.supplier.store.ajaxSave');
        Route::get('/inventory-setup-supplier-edit/{id}', 'SupplierController@edit')->name('inventorySetup.supplier.edit');
        Route::post('/inventory-setup-supplier-update/{id}', 'SupplierController@update')->name('inventorySetup.supplier.update');
        Route::get('/inventory-setup-supplier-delete/{id}', 'SupplierController@destroy')->name('inventorySetup.supplier.destroy');
        Route::get('/inventory-setup-supplier-status/{id}/{status}', 'SupplierController@statusUpdate')->name('inventorySetup.supplier.status');
        Route::post('/inventory-setup-supplier-import', 'SupplierController@supplierImport')->name('inventorySetup.supplier.import');
        Route::get('/inventory-setup-supplier-explode', 'SupplierController@supplierExplode')->name('inventorySetup.supplier.explode');
        //Supplier  crud operation end

        //Supplier Group crud operation start
        Route::get('/inventory-setup-supplierGroup-list', 'SupplierGroupController@index')->name('inventorySetup.supplierGroup.index');
        Route::get('/dataProcessingSupplierGroup', 'SupplierGroupController@dataProcessingSupplierGroup')->name('inventorySetup.supplierGroup.dataProcessingSupplierGroup');
        Route::get('/inventory-setup-supplierGroup-create', 'SupplierGroupController@create')->name('inventorySetup.supplierGroup.create');
        Route::post('/inventory-setup-supplierGroup-store', 'SupplierGroupController@store')->name('inventorySetup.supplierGroup.store');
        Route::get('/inventory-setup-supplierGroup-store-ajax', 'SupplierGroupController@loadModal')->name('inventorySetup.supplierGroup.store.ajax');
        Route::post('/inventory-setup-supplierGroup-store-ajax-save', 'SupplierGroupController@ajaxSave')->name('inventorySetup.supplierGroup.store.ajaxSave');
        Route::get('/inventory-setup-supplierGroup-edit/{id}', 'SupplierGroupController@edit')->name('inventorySetup.supplierGroup.edit');
        Route::post('/inventory-setup-supplierGroup-update/{id}', 'SupplierGroupController@update')->name('inventorySetup.supplierGroup.update');
        Route::get('/inventory-setup-supplierGroup-delete/{id}', 'SupplierGroupController@destroy')->name('inventorySetup.supplierGroup.destroy');
        Route::get('/inventory-setup-supplierGroup-status/{id}/{status}', 'SupplierGroupController@statusUpdate')->name('inventorySetup.supplierGroup.status');
        Route::post('/inventory-setup-supplierGroup-import', 'SupplierGroupController@supplierGroupImport')->name('inventorySetup.supplierGroup.import');
        Route::get('/inventory-setup-supplierGroup-explode', 'SupplierGroupController@supplierGroupExplode')->name('inventorySetup.supplierGroup.explode');
        //Supplier Group crud operation end

    });


    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'InventoryTransaction'], function () {

        //purchases orders  crud operation start
        Route::get('/inventory-transaction-purchases-orders-list', 'PurchasesOrderController@index')->name('inventoryTransaction.purchasesOrder.index');
        Route::get('/dataProcessingPurchasesOrder', 'PurchasesOrderController@dataProcessingPurchasesOrder')->name('inventoryTransaction.purchasesOrder.dataProcessingPurchasesOrder');
        Route::get('/inventory-transaction-purchases-orders-create', 'PurchasesOrderController@create')->name('inventoryTransaction.purchasesOrder.create');
        Route::post('/inventory-transaction-purchases-orders-store', 'PurchasesOrderController@store')->name('inventoryTransaction.purchasesOrder.store');
        Route::get('/inventory-transaction-purchases-orders-edit/{id}', 'PurchasesOrderController@edit')->name('inventoryTransaction.purchasesOrder.edit');
        Route::get('/inventory-transaction-purchases-orders-show/{id}', 'PurchasesOrderController@show')->name('inventoryTransaction.purchasesOrder.show');
        Route::post('/inventory-transaction-purchases-orders-update/{id}', 'PurchasesOrderController@update')->name('inventoryTransaction.purchasesOrder.update');
        Route::get('/inventory-transaction-purchases-orders-delete/{id}', 'PurchasesOrderController@destroy')->name('inventoryTransaction.purchasesOrder.destroy');
        Route::get('/inventory-transaction-purchases-orders-status/{id}/{status}', 'PurchasesOrderController@statusUpdate')->name('inventoryTransaction.purchasesOrder.status');
        Route::get('/inventory-transaction-purchases-orders-detailsInfo', 'PurchasesOrderController@detailsInfo')->name('inventoryTransaction.purchasesOrder.detailsInfo');
        Route::get('/inventory-transaction-purchases-orders-approved/{order_id}/{status}', 'PurchasesOrderController@approved')->name('inventoryTransaction.purchasesOrder.approved');
        //purchases orders  crud operation end


        //purchases  crud operation start
        Route::get('/inventory-transaction-purchases-list', 'PurchasesController@index')->name('inventoryTransaction.purchases.index');
        Route::get('/dataProcessingPurchases', 'PurchasesController@dataProcessingPurchases')->name('inventoryTransaction.purchases.dataProcessingPurchases');
        Route::get('/inventory-transaction-purchases-create', 'PurchasesController@create')->name('inventoryTransaction.purchases.create');
        Route::post('/inventory-transaction-purchases-store', 'PurchasesController@store')->name('inventoryTransaction.purchases.store');
        Route::get('/inventory-transaction-purchases-edit/{id}', 'PurchasesController@edit')->name('inventoryTransaction.purchases.edit');
        Route::get('/inventory-transaction-purchases-approved/{id}', 'PurchasesController@purchasesApproved')->name('inventoryTransaction.purchases.purchasesApproved');
        Route::get('/inventory-transaction-purchases-account-approved/{purchases_id}/{status}', 'PurchasesController@accountApproved')->name('inventoryTransaction.purchases.accountApproved');
        Route::get('/inventory-transaction-purchases-show/{id}', 'PurchasesController@show')->name('inventoryTransaction.purchases.show');
        Route::post('/inventory-transaction-purchases-update/{id}', 'PurchasesController@update')->name('inventoryTransaction.purchases.update');
        Route::get('/inventory-transaction-purchases-delete/{id}', 'PurchasesController@destroy')->name('inventoryTransaction.purchases.destroy');
        Route::get('/inventory-transaction-purchases-status/{id}/{status}', 'PurchasesController@statusUpdate')->name('inventoryTransaction.purchases.status');
        Route::get('/inventory-transaction-purchases-detailsInfo', 'PurchasesController@detailsInfo')->name('inventoryTransaction.purchases.detailsInfo');
        //purchases  crud operation end

        //due purchases  crud operation start
        Route::get('/inventory-transaction-purchases-payment-list', 'PurchasesPaymentController@index')->name('inventoryTransaction.purchasesPayment.index');
        Route::get('/dataProcessingPurchasesPayment', 'PurchasesPaymentController@dataProcessingPurchasesPayment')->name('inventoryTransaction.purchasesPayment.dataProcessingPurchasesPayment');
        Route::get('/inventory-transaction-purchases-payment-create', 'PurchasesPaymentController@create')->name('inventoryTransaction.purchasesPayment.create');
        Route::post('/inventory-transaction-purchases-payment-store', 'PurchasesPaymentController@store')->name('inventoryTransaction.purchasesPayment.store');
        Route::get('/inventory-transaction-purchases-due-voucher-list', 'PurchasesPaymentController@supplierDueVoucherList')->name('inventoryTransaction.purchasesPayment.dueVoucherList');
        Route::get('/inventory-transaction-purchases-payment-show/{id}', 'PurchasesPaymentController@show')->name('inventoryTransaction.purchasesPayment.show');
        //due purchases  crud operation end

          //inventory adjustment  crud operation start
          Route::get('/inventory-transaction-adjustment-list', 'InventoryAdjustmentController@index')->name('inventoryTransaction.inventoryAdjustment.index');
          Route::get('/dataProcessingInventoryAdjustment',   'InventoryAdjustmentController@dataProcessingInventoryAdjustment')->name('inventoryTransaction.inventoryAdjustment.dataProcessingInventoryAdjustment');
          Route::get('/inventory-transaction-adjustment-create', 'InventoryAdjustmentController@create')->name('inventoryTransaction.inventoryAdjustment.create');
          Route::post('/inventory-transaction-adjustment-store', 'InventoryAdjustmentController@store')->name('inventoryTransaction.inventoryAdjustment.store');
          Route::get('/inventory-transaction-adjustment-edit/{id}', 'InventoryAdjustmentController@edit')->name('inventoryTransaction.inventoryAdjustment.edit');
          Route::get('/inventory-transaction-adjustment-show/{id}', 'InventoryAdjustmentController@show')->name('inventoryTransaction.inventoryAdjustment.show');
  
          Route::get('/inventory-transaction-adjustment-batch', 'InventoryAdjustmentController@getBatch')->name('inventoryTransaction.inventoryAdjustment.batch');
          Route::get('/inventory-transaction-adjustment-batch-stock', 'InventoryAdjustmentController@getBatchStock')->name('inventoryTransaction.inventoryAdjustment.batch.stock');
  
          Route::post('/inventory-transaction-adjustment-update/{id}', 'InventoryAdjustmentController@update')->name('inventoryTransaction.inventoryAdjustment.update');
          Route::get('/inventory-transaction-adjustment-delete/{id}', 'InventoryAdjustmentController@destroy')->name('inventoryTransaction.inventoryAdjustment.destroy');
          Route::get('/inventory-transaction-adjustment-status/{id}/{status}', 'InventoryAdjustmentController@statusUpdate')->name('inventoryTransaction.inventoryAdjustment.status');
          Route::get('/inventory-transaction-adjustment-detailsInfo', 'InventoryAdjustmentController@detailsInfo')->name('inventoryTransaction.inventoryAdjustment.detailsInfo');
          //inventory adjustment  crud operation end

        //purchases pending check Approved  crud operation start
        Route::get('/inventory-transaction-purchases-pending-cheque-list', 'PurchasesPendingChequeController@index')->name('inventoryTransaction.purchases.pendingCheque.index');
        Route::get('/dataProcessingPurchasesPendingCheque', 'PurchasesPendingChequeController@dataProcessingPurchasesPendingCheque')->name('inventoryTransaction.purchases.pendingCheque.dataProcessingPurchasesPendingCheque');
        Route::get('/inventory-transaction-purchases-pending-cheque-create', 'PurchasesPendingChequeController@create')->name('inventoryTransaction.purchases.pendingCheque.create');
        Route::post('/inventory-transaction-purchases-pending-cheque-store', 'PurchasesPendingChequeController@store')->name('inventoryTransaction.purchases.pendingCheque.store');
        Route::get('/inventory-transaction-purchases-pending-cheque-approved/{id}/{status}', 'PurchasesPendingChequeController@purchasesPendingChequeApproved')->name('inventoryTransaction.purchases.pendingCheque.approved');
        Route::get('/inventory-transaction-purchases-pending-cheque-show/{id}', 'PurchasesPendingChequeController@show')->name('inventoryTransaction.purchases.pendingCheque.show');

        //purchases pending check Approved  crud operation end

        //purchases crud operation start
        Route::get('/inventory-transaction-purchases-details-create', 'PurchasesController@create')->name('inventoryTransaction.purchases.details.create');
        //purchases crud operation end

         //purchases MRR crud operation start
         Route::get('/inventory-transaction-purchases-mrr-list', 'PurchasesMrrController@index')->name('inventoryTransaction.purchasesMRR.index');
         Route::get('/dataProcessingpurchasesMRR', 'PurchasesMrrController@dataProcessingpurchasesMRR')->name('inventoryTransaction.purchasesMRR.dataProcessingpurchasesMRR');
         Route::get('/inventory-transaction-purchases-mrr-create', 'PurchasesMrrController@create')->name('inventoryTransaction.purchasesMRR.create');
         Route::post('/inventory-transaction-purchases-mrr-store', 'PurchasesMrrController@store')->name('inventoryTransaction.purchasesMRR.store');
         Route::get('/inventory-transaction-purchases-mrr-edit/{id}', 'PurchasesMrrController@edit')->name('inventoryTransaction.purchasesMRR.edit');
         Route::get('/inventory-transaction-purchases-mrr-show/{id}', 'PurchasesMrrController@show')->name('inventoryTransaction.purchasesMRR.show');
         Route::post('/inventory-transaction-purchases-mrr-update/{id}', 'PurchasesMrrController@update')->name('inventoryTransaction.purchasesMRR.update');
         Route::get('/inventory-transaction-purchases-mrr-delete/{id}', 'PurchasesMrrController@destroy')->name('inventoryTransaction.purchasesMRR.destroy');
         Route::get('/inventory-transaction-purchases-mrr-status/{id}/{status}', 'PurchasesMrrController@statusUpdate')->name('inventoryTransaction.purchasesMRR.status');
         //purchases MRR crud operation end
 
         //purchases MRR crud operation start
         Route::get('/inventory-transaction-purchases-mrr-details-create', 'PurchasesMrrController@create')->name('inventoryTransaction.purchases.details.create');
         //purchases MRR crud operation end

        //purchases Requisition  crud operation start
        Route::get('/inventory-transaction-purchases-requisition-list', 'PurchasesRequsitionController@index')->name('inventoryTransaction.purchasesRequisition.index');
        Route::get('/dataProcessingpurchasesRequisition',   'PurchasesRequsitionController@dataProcessingpurchasesRequisition')->name('inventoryTransaction.purchasesRequisition.dataProcessingpurchasesRequisition');
        Route::get('/inventory-transaction-purchases-requisition-create', 'PurchasesRequsitionController@create')->name('inventoryTransaction.purchasesRequisition.create');
        Route::post('/inventory-transaction-purchases-requisition-store', 'PurchasesRequsitionController@store')->name('inventoryTransaction.purchasesRequisition.store');
        Route::get('/inventory-transaction-purchases-requisition-edit/{id}', 'PurchasesRequsitionController@edit')->name('inventoryTransaction.purchasesRequisition.edit');
        Route::get('/inventory-transaction-purchases-requisition-show/{id}', 'PurchasesRequsitionController@show')->name('inventoryTransaction.purchasesRequisition.show');
        Route::post('/inventory-transaction-purchases-requisition-update/{id}', 'PurchasesRequsitionController@update')->name('inventoryTransaction.purchasesRequisition.update');
        Route::get('/inventory-transaction-purchases-requisition-delete/{id}', 'PurchasesRequsitionController@destroy')->name('inventoryTransaction.purchasesRequisition.destroy');
        Route::get('/inventory-transaction-purchases-requisition-status/{id}/{status}', 'PurchasesRequsitionController@statusUpdate')->name('inventoryTransaction.purchasesRequisition.status');
        Route::get('/inventory-transaction-purchases-requisition-detailsInfo', 'PurchasesRequsitionController@detailsInfo')->name('inventoryTransaction.purchasesRequisition.detailsInfo');
        Route::get('/inventory-transaction-purchases-requisition-approved/{requisition_id}/{status}', 'PurchasesRequsitionController@approved')->name('inventoryTransaction.purchasesRequisition.approved');

        //purchases Requisition  crud operation end

        //purchases Requisition crud operation start
        Route::get('/inventory-transaction-purchases-requisition-details-create', 'PurchasesRequsitionController@create')->name('inventoryTransaction.purchasesRequisition.details.create');
        //purchases Requisition crud operation end

        //transfer  crud operation start
        Route::get('/inventory-transaction-transfer-list', 'TransferController@index')->name('inventoryTransaction.transfer.index');
        Route::get('/dataProcessingTransfer', 'TransferController@dataProcessingTransfer')->name('inventoryTransaction.transfer.dataProcessingTransfer');
        Route::get('/inventory-transaction-transfer-create', 'TransferController@create')->name('inventoryTransaction.transfer.create');
        Route::post('/inventory-transaction-transfer-store', 'TransferController@store')->name('inventoryTransaction.transfer.store');
        Route::get('/inventory-transaction-transfer-edit/{id}', 'TransferController@edit')->name('inventoryTransaction.transfer.edit');
        Route::get('/inventory-transaction-transfer-show/{id}', 'TransferController@show')->name('inventoryTransaction.transfer.show');
        Route::post('/inventory-transaction-transfer-update/{id}', 'TransferController@update')->name('inventoryTransaction.transfer.update');
        Route::get('/inventory-transaction-transfer-delete/{id}', 'TransferController@destroy')->name('inventoryTransaction.transfer.destroy');
        Route::get('/inventory-transaction-transfer-status/{id}/{status}', 'TransferController@statusUpdate')->name('inventoryTransaction.transfer.status');
        //transfer  crud operation end

        //transfer crud operation start
        Route::get('/inventory-transaction-transfer-details-create', 'TransferController@create')->name('inventoryTransaction.transfer.details.create');
        //transfer crud operation end

        //purchases  return operation start
        Route::get('/inventory-transaction-purchases-return-list', 'PurchasesReturnController@index')->name('inventoryTransaction.purchasesReturn.index');
        Route::get('/dataProcessingPurchasesReturn', 'PurchasesReturnController@dataProcessingPurchasesReturn')->name('inventoryTransaction.purchasesReturn.dataProcessingPurchasesReturn');
        Route::get('/inventory-transaction-purchases-return-create', 'PurchasesReturnController@create')->name('inventoryTransaction.purchasesReturn.create');
        Route::post('/inventory-transaction-purchases-return-store', 'PurchasesReturnController@store')->name('inventoryTransaction.purchasesReturn.store');
        Route::get('/inventory-transaction-purchases-return-edit/{id}', 'PurchasesReturnController@edit')->name('inventoryTransaction.purchasesReturn.edit');
        Route::get('/inventory-transaction-purchases-list-autocomplete', 'PurchasesReturnController@purchasesListAutocomplete')->name('inventoryTransaction.purchasesReturn.autocomplete');
        Route::get('/inventory-transaction-purchases-details', 'PurchasesReturnController@purchasesDetails')->name('inventoryTransaction.purchases.details');
        Route::get('/inventory-transaction-purchases-return-show/{id}', 'PurchasesReturnController@show')->name('inventoryTransaction.purchasesReturn.show');
        Route::post('/inventory-transaction-purchases-return-update/{id}', 'PurchasesReturnController@update')->name('inventoryTransaction.purchasesReturn.update');
        Route::get('/inventory-transaction-purchases-return-delete/{id}', 'PurchasesReturnController@destroy')->name('inventoryTransaction.purchasesReturn.destroy');
        Route::get('/inventory-transaction-purchases-return-status/{id}/{status}', 'PurchasesReturnController@statusUpdate')->name('inventoryTransaction.purchasesReturn.status');
        Route::get('/inventory-transaction-purchases-return-detailsInfo', 'PurchasesReturnController@detailsInfo')->name('inventoryTransaction.purchasesReturn.detailsInfo');
        Route::get('/inventory-transaction-purchases-return-approved/{id}/{status}', 'PurchasesReturnController@approved')->name('inventoryTransaction.purchasesReturn.approved');

        //purchases return crud operation 
        Route::get('/inventory-transaction-purchases-return-details-create', 'PurchasesReturnController@create')->name('inventoryTransaction.purchasesReturn.details.create');
        Route::get('/inventory-transaction-purchases-details-create', 'PurchasesController@create')->name('inventoryTransaction.purchases.details.create');
        //purchases return crud operation end
    });
    

    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'PurchasesReport'], function () {
        //purchases report crud operation start
        Route::any('/purchases-report-supplier-ledger', 'PurchasesReport@supplierLedger')->name('purchasesReport.supplierLedger');
        Route::any('/purchases-report-stock-ledger', 'StockReport@stockLedger')->name('purchasesReport.stockLedger');
        Route::any('/purchases-report-date-and-supplier-wise', 'PurchasesReport@purchasesReport')->name('purchasesReport.dateAndSupplierWise');
        Route::any('/purchases-report-product-ledger', 'PurchasesReport@productLedger')->name('purchasesReport.productLedger');
        Route::any('/purchases-report-transfer-report', 'PurchasesReport@transferReport')->name('purchasesReport.transferReport');
        //purchases report crud operation start
    
    });
    
});
