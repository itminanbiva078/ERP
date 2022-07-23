<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {
    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'AccountSetup'], function () {
        //accounts  crud operation start
        Route::get('/account-setup-chartOfAccount-list', 'ChartOfAccountController@index')->name('accountSetup.chartOfAccount.index');
        Route::get('/dataProcessingChartOfAccount', 'ChartOfAccountController@dataProcessingChartOfAccount')->name('accountSetup.chartOfAccount.dataProcessingChartOfAccount');
        Route::get('/account-setup-chartOfAccount-create', 'ChartOfAccountController@create')->name('accountSetup.chartOfAccount.create');
        Route::post('/account-setup-chartOfAccount-store', 'ChartOfAccountController@store')->name('accountSetup.chartOfAccount.store');
        Route::get('/account-setup-chartOfAccount-edit/{id}', 'ChartOfAccountController@edit')->name('accountSetup.chartOfAccount.edit');
        Route::get('/account-setup-chartOfAccount-details', 'ChartOfAccountController@chartOfAccount')->name('accountSetup.chartOfAccount.details');
        Route::post('/account-setup-chartOfAccount-update/{id}', 'ChartOfAccountController@update')->name('accountSetup.chartOfAccount.update');
        Route::get('/account-setup-chartOfAccount-byTypeWise', 'ChartOfAccountController@chartListByTypeWise')->name('accountSetup.chartOfAccount.typeWiseList');
        Route::get('/account-setup-chartOfAccount-delete/{id}', 'ChartOfAccountController@destroy')->name('accountSetup.chartOfAccount.destroy');
        Route::get('/account-setup-chartOfAccount-status/{id}/{status}', 'ChartOfAccountController@statusUpdate')->name('accountSetup.chartOfAccount.status');
        Route::get('/account-setup-chartOfAccount-balance', 'ChartOfAccountController@getAccountBalance')->name('accountSetup.chartOfAccount.getAccountBalance');
        Route::get('/account-setup-chartOfAccount-bank-balance', 'ChartOfAccountController@getAccountBankBalance')->name('accountSetup.chartOfAccount.getAccountBankBalance');
        Route::get('/account-setup-chartOfAccount-accountLedgerTypeWise', 'ChartOfAccountController@getAccountHeadTypeWise')->name('accountSetup.chartOfAccount.getAccountHeadTypeWise');

        //accounts crud operation end

        //bank  crud operation start
        Route::get('/account-setup-bank-account-list', 'BankController@index')->name('accountSetup.bank.index');
        Route::get('/dataProcessingBank', 'BankController@dataProcessingBank')->name('accountSetup.bank.dataProcessingBank');
        Route::get('/account-setup-bank-account-create', 'BankController@create')->name('accountSetup.bank.create');
        Route::post('/account-setup-bank-account-store', 'BankController@store')->name('accountSetup.bank.store');
        Route::get('/account-setup-bank-account-edit/{id}', 'BankController@edit')->name('accountSetup.bank.edit');
        Route::post('/account-setup-bank-account-update/{id}', 'BankController@update')->name('accountSetup.bank.update');
        Route::get('/account-setup-bank-account-delete/{id}', 'BankController@destroy')->name('accountSetup.bank.destroy');
        Route::get('/account-setup-bank-account-status/{id}/{status}', 'BankController@statusUpdate')->name('accountSetup.bank.status');
        Route::post('/account-setup-bank-account-import', 'BankController@bankImport')->name('accountSetup.bank.import');
        Route::get('/account-setup-bank-account-explode', 'BankController@bankExplode')->name('accountSetup.bank.explode');
        //bank crud operation end

        //account type crud operation start
        Route::get('/account-setup-account-type-list', 'AccountTypeController@index')->name('accountSetup.accountType.index');
        Route::get('/dataProcessingAccountType', 'AccountTypeController@dataProcessingAccountType')->name('accountSetup.accountType.dataProcessingAccountType');
        Route::get('/account-setup-account-type-create', 'AccountTypeController@create')->name('accountSetup.accountType.create');
        Route::post('/account-setup-account-type-store', 'AccountTypeController@store')->name('accountSetup.accountType.store');
        Route::get('/account-setup-account-type-edit/{id}', 'AccountTypeController@edit')->name('accountSetup.accountType.edit');
        Route::post('/account-setup-account-type-update/{id}', 'AccountTypeController@update')->name('accountSetup.accountType.update');
        Route::get('/account-setup-account-type-delete/{id}', 'AccountTypeController@destroy')->name('accountSetup.accountType.destroy');
        Route::get('/account-setup-account-type-status/{id}/{status}', 'AccountTypeController@statusUpdate')->name('accountSetup.accountType.status');
        //account type crud operation end

        //opening balance crud operation start
        // Route::get('/account-setup-opening-type-list', 'AccountTypeController@index')->name('accountSetup.accountType.index');
        Route::get('/account-setup-opening-balance-edit', 'OpeningBalanceController@edit')->name('accountSetup.openingBalance.edit');
        Route::post('/account-setup-opening-balance-update', 'OpeningBalanceController@update')->name('accountSetup.openingBalance.update');
        //opening balance crud operation end

    });




    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'AccountTransaction'], function () {
        //payment-voucher  crud operation start
        Route::get('/account-transaction-paymentVoucher-list', 'PaymentVoucherController@index')->name('accountTransaction.paymentVoucher.index');
        Route::get('/dataProcessingPaymentVoucher', 'PaymentVoucherController@dataProcessingPaymentVoucher')->name('accountTransaction.paymentVoucher.dataProcessingPaymentVoucher');
        Route::get('/account-transaction-paymentVoucher-create', 'PaymentVoucherController@create')->name('accountTransaction.paymentVoucher.create');
        Route::post('/account-transaction-paymentVoucher-store', 'PaymentVoucherController@store')->name('accountTransaction.paymentVoucher.store');
        Route::get('/account-transaction-paymentVoucher-edit/{id}', 'PaymentVoucherController@edit')->name('accountTransaction.paymentVoucher.edit');
        Route::get('/account-transaction-paymentVoucher-show/{id}', 'PaymentVoucherController@show')->name('accountTransaction.paymentVoucher.show');
        Route::post('/account-transaction-paymentVoucher-update/{id}', 'PaymentVoucherController@update')->name('accountTransaction.paymentVoucher.update');
        Route::get('/account-transaction-paymentVoucher-delete/{id}', 'PaymentVoucherController@destroy')->name('accountTransaction.paymentVoucher.destroy');
        Route::get('/account-transaction-paymentVoucher-status/{id}/{status}', 'PaymentVoucherController@statusUpdate')->name('accountTransaction.paymentVoucher.status');
        Route::get('/account-transaction-paymentVoucher-details-create', 'PaymentVoucherController@create')->name('accountTransaction.paymentVoucher.details.create');
        Route::get('/account-transaction-paymentVoucher-accountApproved/{id}/{status}', 'PaymentVoucherController@accountApproved')->name('accountTransaction.paymentVoucher.accountApproved');
        //payment-voucher Unit crud operation end

        //journal-voucher  crud operation start
        Route::get('/account-transaction-journalVoucher-list', 'JournalVoucherController@index')->name('accountTransaction.journalVoucher.index');
        Route::get('/dataProcessingJournalVoucher', 'JournalVoucherController@dataProcessingJournalVoucher')->name('accountTransaction.journalVoucher.dataProcessingJournalVoucher');
        Route::get('/account-transaction-journalVoucher-create', 'JournalVoucherController@create')->name('accountTransaction.journalVoucher.create');
        Route::post('/account-transaction-journalVoucher-store', 'JournalVoucherController@store')->name('accountTransaction.journalVoucher.store');
        Route::get('/account-transaction-journalVoucher-edit/{id}', 'JournalVoucherController@edit')->name('accountTransaction.journalVoucher.edit');
        Route::get('/account-transaction-journalVoucher-show/{id}', 'JournalVoucherController@show')->name('accountTransaction.journalVoucher.show');
        Route::post('/account-transaction-journalVoucher-update/{id}', 'JournalVoucherController@update')->name('accountTransaction.journalVoucher.update');
        Route::get('/account-transaction-journalVoucher-delete/{id}', 'JournalVoucherController@destroy')->name('accountTransaction.journalVoucher.destroy');
        Route::get('/account-transaction-journalVoucher-status/{id}/{status}', 'JournalVoucherController@statusUpdate')->name('accountTransaction.journalVoucher.status');
        Route::get('/account-transaction-journalVoucher-details-create', 'JournalVoucherController@create')->name('accountTransaction.journalVoucher.details.create');
        Route::get('/account-transaction-journalVoucher-accountApproved/{id}/{status}', 'JournalVoucherController@accountApproved')->name('accountTransaction.journalVoucher.accountApproved');

        //journal-voucher crud operation end

        //contra-voucher  crud operation start
        Route::get('/account-transaction-contralVoucher-list', 'ContraVoucherController@index')->name('accountTransaction.contralVoucher.index');
        Route::get('/dataProcessingContralVoucher', 'ContraVoucherController@dataProcessingContralVoucher')->name('accountTransaction.contralVoucher.dataProcessingContralVoucher');
        Route::get('/account-transaction-contralVoucher-create', 'ContraVoucherController@create')->name('accountTransaction.contralVoucher.create');
        Route::post('/account-transaction-contralVoucher-store', 'ContraVoucherController@store')->name('accountTransaction.contralVoucher.store');
        Route::get('/account-transaction-contralVoucher-edit/{id}', 'ContraVoucherController@edit')->name('accountTransaction.contralVoucher.edit');
        Route::get('/account-transaction-contralVoucher-show/{id}', 'ContraVoucherController@show')->name('accountTransaction.contralVoucher.show');
        Route::post('/account-transaction-contralVoucher-update/{id}', 'ContraVoucherController@update')->name('accountTransaction.contralVoucher.update');
        Route::get('/account-transaction-contralVoucher-delete/{id}', 'ContraVoucherController@destroy')->name('accountTransaction.contralVoucher.destroy');
        Route::get('/account-transaction-contralVoucher-status/{id}/{status}', 'ContraVoucherController@statusUpdate')->name('accountTransaction.contralVoucher.status');
        Route::get('/account-transaction-contralVoucher-details-create', 'ContraVoucherController@create')->name('accountTransaction.contralVoucher.details.create');

        //contra-voucher crud operation end

        //receiveVoucher  crud operation start
        Route::get('/account-transaction-receiveVoucher-list', 'ReceiveVoucherController@index')->name('accountTransaction.receiveVoucher.index');
        Route::get('/dataProcessingReceiveVoucher', 'ReceiveVoucherController@dataProcessingReceiveVoucher')->name('accountTransaction.receiveVoucher.dataProcessingReceiveVoucher');
        Route::get('/account-transaction-receiveVoucher-create', 'ReceiveVoucherController@create')->name('accountTransaction.receiveVoucher.create');
        Route::post('/account-transaction-receiveVoucher-store', 'ReceiveVoucherController@store')->name('accountTransaction.receiveVoucher.store');
        Route::get('/account-transaction-receiveVoucher-edit/{id}', 'ReceiveVoucherController@edit')->name('accountTransaction.receiveVoucher.edit');
        Route::get('/account-transaction-receiveVoucher-show/{id}', 'ReceiveVoucherController@show')->name('accountTransaction.receiveVoucher.show');
        Route::post('/account-transaction-receiveVoucher-update/{id}', 'ReceiveVoucherController@update')->name('accountTransaction.receiveVoucher.update');
        Route::get('/account-transaction-receiveVoucher-delete/{id}', 'ReceiveVoucherController@destroy')->name('accountTransaction.receiveVoucher.destroy');
        Route::get('/account-transaction-receiveVoucher-status/{id}/{status}', 'ReceiveVoucherController@statusUpdate')->name('accountTransaction.receiveVoucher.status');
        Route::get('/account-transaction-receiveVoucher-details-create', 'ReceiveVoucherController@create')->name('accountTransaction.receiveVoucher.details.create');
        Route::get('/account-transaction-receiveVoucher-accountApproved/{id}/{status}', 'ReceiveVoucherController@accountApproved')->name('accountTransaction.receiveVoucher.accountApproved');

        //receiveVoucher crud operation end

    });

    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'AccountReport'], function () {
        Route::any('/account-report-general-ledger', 'AccountReport@generalLedger')->name('accountReport.generalLedger');
        Route::any('/account-report-trial-balance', 'AccountReport@trialBalance')->name('accountReport.trialBalance');
        Route::any('/account-report-balance-sheet', 'AccountReport@balanceSheet')->name('accountReport.balanceSheet');
        Route::any('/account-report-income-statement', 'AccountReport@incomeStatement')->name('accountReport.incomeStatement');
        Route::any('/account-report-journal-statement', 'AccountReport@journalCheck')->name('accountReport.accountJournalCheck');
        Route::any('/account-report-journal-statement', 'AccountReport@journalCheck')->name('accountReport.journalCheck');

    });

});
