<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {
   

    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Booking'], function () {
        //booking crud operation start
        Route::get('/booking-booking-list', 'BookingController@index')->name('booking.booking.index');
        Route::get('/dataProcessingBooking', 'BookingController@dataProcessingBooking')->name('booking.booking.dataProcessingBooking');
        Route::get('/booking-booking-create', 'BookingController@create')->name('booking.booking.create');
        Route::get('/booking-booking-save/{id}', 'BookingController@selectBookinCreate')->name('booking.selectCreate');
        Route::get('/booking-booking-search-available-room', 'BookingController@searchAvailableRoom')->name('booking.search.avaialble.room');
        Route::post('/booking-booking-store', 'BookingController@store')->name('booking.booking.store');
        Route::get('/booking-booking-edit/{id}', 'BookingController@edit')->name('booking.booking.edit');
        Route::get('/booking-booking-show/{id}', 'BookingController@show')->name('booking.booking.show');
        Route::post('/booking-booking-update/{id}', 'BookingController@update')->name('booking.booking.update');
        Route::get('/booking-booking-delete/{id}', 'BookingController@destroy')->name('booking.booking.destroy');
        Route::get('/booking-booking-status/{booking_status_id}/{status}', 'BookingController@approved')->name('booking.booking.approved');


        Route::get('/booking-booking-payment-status/{id}/{payment_status}', 'BookingController@PaymentStatusUpdate')->name('booking.booking.payment_status');
        //booking crud operation end

    });
});
