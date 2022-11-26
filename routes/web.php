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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/clear', function() {
     
     Artisan::call('config:cache');
     Artisan::call('cache:clear');
     Artisan::call('view:clear');
     return 'Routes cache cleared';
 });
 Route::get('test','App\Http\Controllers\AdminController@test');
Route::get('/','App\Http\Controllers\AdminController@index');
Route::get('/login', function () {
    return view('admin-panel.login');
})->name('login');
Route::post('login','App\Http\Controllers\AdminController@login');
Route::middleware(['auth'])->group(function () {

Route::get('logout','App\Http\Controllers\AdminController@logout');

Route::get('sentmessage', function () {
    return view('sentmessage');
});


Route::get('table', function () {
    return view('admin-panel.table');
});

Route::get('chat','App\Http\Controllers\AdminController@chat');

Route::get('get-events/{hotel_id}','App\Http\Controllers\AdminController@getEvents');
Route::get('submit-event/{reserveDate}/{eventDate}/{numberOfChildren}/{numberOfPeople}/{hoursFrom}/{hoursTo}/{service}/{customer}','App\Http\Controllers\AdminController@submitEvent');

Route::get('calender', function () {
    return view('admin-panel.calenders.index');
});

Route::get('form', function () {
    return view('admin-panel.form');
});
/*Route::get('test', function () {
    return view('admin-panel.test');
});*/

Route::get('update-chat','App\Http\Controllers\AdminController@updateChat');
Route::get('send-message/{id}/{msg}','App\Http\Controllers\AdminController@sendMessage');


Route::get('hotels-accounts','App\Http\Controllers\HotelController@index');
Route::get('hotels-accounts-create','App\Http\Controllers\HotelController@create');
Route::post('hotels-accounts-store','App\Http\Controllers\HotelController@store');
Route::get('hotels-accounts-edit/{id}','App\Http\Controllers\HotelController@edit');
Route::post('hotels-accounts-update/{id}','App\Http\Controllers\HotelController@update');
Route::get('hotels-accounts-delete/{id}','App\Http\Controllers\HotelController@delete');

Route::get('info-fields','App\Http\Controllers\InfoFieldController@index');
Route::get('info-fields-create','App\Http\Controllers\InfoFieldController@create');
Route::post('info-fields-store','App\Http\Controllers\InfoFieldController@store');
Route::get('info-fields-edit/{id}','App\Http\Controllers\InfoFieldController@edit');
Route::post('info-fields-update/{id}','App\Http\Controllers\InfoFieldController@update');
Route::get('info-fields-delete/{id}','App\Http\Controllers\InfoFieldController@delete');

Route::get('customer-fields','App\Http\Controllers\CustomerFieldController@index');
Route::get('customer-fields-create','App\Http\Controllers\CustomerFieldController@create');
Route::post('customer-fields-store','App\Http\Controllers\CustomerFieldController@store');
Route::get('customer-fields-edit/{id}','App\Http\Controllers\CustomerFieldController@edit');
Route::post('customer-fields-update/{id}','App\Http\Controllers\CustomerFieldController@update');
Route::get('customer-fields-delete/{id}','App\Http\Controllers\CustomerFieldController@delete');

Route::get('product-fields','App\Http\Controllers\ProductFieldController@index');
Route::get('product-fields-create','App\Http\Controllers\ProductFieldController@create');
Route::post('product-fields-store','App\Http\Controllers\ProductFieldController@store');
Route::get('product-fields-edit/{id}','App\Http\Controllers\ProductFieldController@edit');
Route::post('product-fields-update/{id}','App\Http\Controllers\ProductFieldController@update');
Route::get('product-fields-delete/{id}','App\Http\Controllers\ProductFieldController@delete');

Route::get('service-fields','App\Http\Controllers\ServiceFieldController@index');
Route::get('service-fields-create','App\Http\Controllers\ServiceFieldController@create');
Route::post('service-fields-store','App\Http\Controllers\ServiceFieldController@store');
Route::get('service-fields-edit/{id}','App\Http\Controllers\ServiceFieldController@edit');
Route::post('service-fields-update/{id}','App\Http\Controllers\ServiceFieldController@update');
Route::get('service-fields-delete/{id}','App\Http\Controllers\ServiceFieldController@delete');

Route::get('customers/{hotel_id}','App\Http\Controllers\CustomerController@index');
Route::get('customers-create/{hotel_id}','App\Http\Controllers\CustomerController@create');
Route::post('customers-store','App\Http\Controllers\CustomerController@store');
Route::get('customers-edit/{id}','App\Http\Controllers\CustomerController@edit');
Route::post('customers-update/{id}','App\Http\Controllers\CustomerController@update');
Route::get('customers-delete/{id}','App\Http\Controllers\CustomerController@delete');
Route::get('bookings/{customer_id}','App\Http\Controllers\BookingController@bookingsOfUser');
Route::get('reserves/{customer_id}','App\Http\Controllers\ReserveController@reservesOfUser');

Route::get('bookings-of-hotel/{hotel_id}','App\Http\Controllers\BookingController@bookingsOfHotel');
Route::get('reserves-of-hotel/{hotel_id}','App\Http\Controllers\ReserveController@reservesOfHotel');

Route::get('products/{catId}','App\Http\Controllers\ProductController@index');
Route::get('products-create/{catId}','App\Http\Controllers\ProductController@create');
Route::post('products-store','App\Http\Controllers\ProductController@store');
Route::get('products-edit/{id}','App\Http\Controllers\ProductController@edit');
Route::post('products-update/{id}','App\Http\Controllers\ProductController@update');
Route::get('products-delete/{id}','App\Http\Controllers\ProductController@delete');

Route::get('services/{catId}','App\Http\Controllers\ServiceController@index');
Route::get('services-create/{catId}','App\Http\Controllers\ServiceController@create');
Route::post('services-store','App\Http\Controllers\ServiceController@store');
Route::get('services-edit/{id}','App\Http\Controllers\ServiceController@edit');
Route::post('services-update/{id}','App\Http\Controllers\ServiceController@update');
Route::get('services-delete/{id}','App\Http\Controllers\ServiceController@delete');

Route::get('informations/{hotel_id}','App\Http\Controllers\InformationController@index');
Route::get('informations-create','App\Http\Controllers\InformationController@create');
Route::post('informations-store','App\Http\Controllers\InformationController@store');
Route::get('informations-edit/{id}','App\Http\Controllers\InformationController@edit');
Route::post('informations-update/{id}','App\Http\Controllers\InformationController@update');
Route::get('informations-delete/{id}','App\Http\Controllers\InformationController@delete');

Route::get('categories/{hotel_id}','App\Http\Controllers\CategoryController@index');
Route::get('categories-create/{hotel_id}','App\Http\Controllers\CategoryController@create');
Route::post('categories-store','App\Http\Controllers\CategoryController@store');
Route::get('categories-edit/{id}','App\Http\Controllers\CategoryController@edit');
Route::post('categories-update/{id}','App\Http\Controllers\CategoryController@update');
Route::get('categories-delete/{id}','App\Http\Controllers\CategoryController@delete');

Route::get('ratings/{hotel_id}','App\Http\Controllers\RatingController@ratingsOfHotel');
Route::get('reserves-in-calender/{hotel_id}','App\Http\Controllers\AdminController@reservesInCalender');

Route::get('get-summary/{id}','App\Http\Controllers\AdminController@getSummary');

Route::get('get-pdf/{id}','App\Http\Controllers\AdminController@getPdf');

Route::post('dynamics-update','App\Http\Controllers\DynamicController@update');
Route::get('dynamics','App\Http\Controllers\DynamicController@index');

Route::get('conditions/{hotel_id}','App\Http\Controllers\ConditionController@index');
Route::post('conditions-update/{id}','App\Http\Controllers\ConditionController@update');

Route::get('notices','App\Http\Controllers\NoticeController@index');
Route::post('notices-update/{id}','App\Http\Controllers\NoticeController@update');

Route::get('formats','App\Http\Controllers\FormatController@index');
Route::get('formats-create','App\Http\Controllers\FormatController@create');
Route::post('formats-store','App\Http\Controllers\FormatController@store');
Route::get('formats-edit/{id}','App\Http\Controllers\FormatController@edit');
Route::post('formats-update/{id}','App\Http\Controllers\FormatController@update');
Route::get('formats-delete/{id}','App\Http\Controllers\FormatController@delete');

Route::get('email-hotels','App\Http\Controllers\FormatController@emailHotels');

Route::get('email-customers','App\Http\Controllers\FormatController@emailCustomers');

Route::post('send-hotels','App\Http\Controllers\FormatController@sendHotels');
Route::post('send-customers','App\Http\Controllers\FormatController@sendCustomers');
});
Route::get('forgot-link/{id}','App\Http\Controllers\AdminController@forgotLink');
Route::post('change','App\Http\Controllers\AdminController@change');
Route::get('change-my-password','App\Http\Controllers\AdminController@changeMyPassword');

Route::get('/forgot', function () {
    return view('admin-panel.forgot');
});
Route::post('forgot','App\Http\Controllers\AdminController@forgot');
