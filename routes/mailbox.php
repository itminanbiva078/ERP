<?php

use Illuminate\Support\Facades\Route;

    Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {
    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Mailbox'], function () {

        //sent crud operation start
        Route::get('/mailbox-sent-list', 'SentController@index')->name('mailbox.sent.index');
        Route::get('/mailbox-sent-create', 'SentController@create')->name('mailbox.sent.create');
        Route::get('/mailbox-mailtype-userlist', 'SentController@getTypeWiseUserList')->name('mailbox.mailtype.userlist');
        Route::post('/mailbox-sent-store', 'SentController@store')->name('mailbox.sent.store');
        Route::get('/mailbox-sent-show/{id}', 'SentController@show')->name('mailbox.sent.show');

       
        //sent crud operation end

        //inbox crud operation start
        Route::get('/mailbox-inbox-list', 'InboxController@index')->name('mailbox.inbox.index');
        Route::get('/mailbox-inbox-show/{id}', 'InboxController@show')->name('mailbox.inbox.show');
        //inbox crud operation end

    });

        
            Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'SMS'], function () {
    
            //sms crud operation start
            Route::get('/sms-sms-list', 'SmsController@index')->name('sms.sms.index');
            Route::get('/sms-sms-create', 'SmsController@create')->name('sms.sms.create');
            Route::get('/sms-smstype-userlist', 'SmsController@getTypeWiseUserList')->name('sms.smstype.userlist');
            Route::post('/sms-sms-store', 'SmsController@store')->name('sms.sms.store');
            Route::get('/sms-sms-show/{id}', 'SmsController@show')->name('sms.sms.show');
            //sms crud operation end
    
    
        });



});
