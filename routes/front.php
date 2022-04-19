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
Route::get('/link', function () {
    Artisan::call('storage:link');
    return 'DONE'; //Return anything
});
Route::get('/', 'FrontendController@index')->name('welcome');
Route::get('/logout_new/{id}', 'FrontendController@logout_new')->name('logout_new');
Route::get('/who_we_are', 'FrontendController@who_we_are')->name('who_we_are');
Route::get('/foundation_of_passion', 'FrontendController@foundation_of_passion')->name('foundation_of_passion');
Route::get('/board_of_director', 'FrontendController@board_of_director')->name('board_of_director');
Route::get('/company_management', 'FrontendController@company_management')->name('company_management');
Route::get('/statement', 'FrontendController@statement')->name('statement');
Route::get('/service', 'FrontendController@service')->name('service');
Route::get('/project', 'FrontendController@project')->name('project');
Route::any('/rooms', 'FrontendController@rooms')->name('rooms');
Route::get('/contact', 'FrontendController@contact')->name('contact');
Route::get('/search_room', 'FrontendController@search_room')->name('search_room');
Route::get('/search_filter', 'FrontendController@search_filter')->name('search_filter');
Route::get('/search_facilities', 'FrontendController@search_facilities')->name('search_facilities');
Route::any('/property_details/{id}', 'FrontendController@property_details')->name('property_details');
Route::get('/category_product/{id}', 'FrontendController@category_product')->name('category_product');
Route::get('/room_list', 'FrontendController@room_list')->name('room_list');
Route::get('/booking_submit', 'FrontendController@booking_submit')->name('booking_submit');
Route::get('/booking_delete/{id}', 'FrontendController@booking_delete')->name('booking_delete');
Route::get('/search_product', 'FrontendController@search_product')->name('search_product');
Route::get('/otp', 'FrontendController@otp')->name('otp');
Route::get('/otp_submit', 'FrontendController@otp_submit')->name('otp_submit');
Route::get('/otp_verification/{id}', 'FrontendController@otp_verification');
Route::post('/otp_submit_login', 'FrontendController@otp_submit_login')->name('otp_submit_login');
Route::get('/profile', 'FrontendController@profile')->name('profile');
Route::get('/logout_customer', 'FrontendController@logout')->name('logout_customer');
Route::post('/review', "FrontendController@sendReview")->name('review');
Route::post('/subscribeEmail', "FrontendController@subscribeEmail")->name('subscribeEmail');
Route::post('/contactSubmit', "FrontendController@contactSubmit")->name('contactSubmit');
Route::get('/book_now/{id}', 'FrontendController@book_now')->name('book_now');
Route::any('/singleRoomFilter', 'FrontendController@singleRoomFilter')->name('singleRoomFilter');
/**/
Route::get('/booking-transaction-booking-list', 'BookingController@index')->name('bookingTransaction.booking.index');
Route::get('/dataProcessingBooking', 'BookingController@dataProcessingBooking')->name('bookingTransaction.booking.dataProcessingBooking');
Route::get('/booking-transaction-booking-status/{id}/{status}', 'BookingController@statusUpdate')->name('bookingTransaction.booking.status');
Route::get('/booking-transaction-booking-payment-status/{id}/{status}', 'BookingController@statusUpdate')->name('bookingTransaction.booking.payment.status');

/**/

/** Amarpay payment gateway Integrate start */
Route::post('/paynow', "AmarpayController@payNow")->name('paynow');

Route::get('/payment','AmarpayController@index');

Route::post('/success','AmarpayController@success')->name('success');

Route::get('/fail','AmarpayController@fail')->name('fail');

Route::get('/cancel','AmarpayController@cancel')->name('cancel');


/** Amarpay payment gateway Integrate end */

Route::group(['prefix' => 'auth'], function () {
    Auth::routes();
});


