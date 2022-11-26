<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('get-hotels','App\Http\Controllers\ApiController@getHotels');
Route::post('get-products-of-hotel','App\Http\Controllers\ApiController@getProductsOfHotel');
Route::post('get-products-of-category','App\Http\Controllers\ApiController@getProductsOfCategory');
Route::post('get-services-of-hotel','App\Http\Controllers\ApiController@getServicesOfHotel');
Route::post('get-services-of-category','App\Http\Controllers\ApiController@getServicesOfCategory');

Route::post('send-message','App\Http\Controllers\ApiController@sendMessage');

Route::post('register','App\Http\Controllers\ApiController@register');
Route::post('login','App\Http\Controllers\ApiController@login');
Route::post('book-product','App\Http\Controllers\ApiController@bookProduct');
Route::post('reserve-service','App\Http\Controllers\ApiController@reserveService');
Route::post('rate-hotel','App\Http\Controllers\ApiController@rateHotel');
Route::post('upload-id-image','App\Http\Controllers\ApiController@uploadIdImage');
Route::post('forgot-password','App\Http\Controllers\ApiController@forgot');
Route::post('change-password','App\Http\Controllers\ApiController@changePassword');
Route::post('get-history','App\Http\Controllers\ApiController@getHistory');
Route::post('check-code','App\Http\Controllers\ApiController@checkCode');
Route::post('booked-products','App\Http\Controllers\ApiController@bookedProducts');
Route::post('reserved-services','App\Http\Controllers\ApiController@reservedServices');
Route::post('set-language','App\Http\Controllers\ApiController@setLanguage');
Route::post('facebook-google','App\Http\Controllers\ApiController@facebookGoogle');
Route::post('get-terms','App\Http\Controllers\ApiController@getTermsConditions');
Route::post('get-notice','App\Http\Controllers\ApiController@getNotice');
Route::post('get-reviews','App\Http\Controllers\ApiController@getReviews');
Route::post('get-hotel-detail','App\Http\Controllers\ApiController@getHotelDetail');
Route::post('get-category-of-services','App\Http\Controllers\ApiController@getCategoryOfServices');
Route::post('get-category-of-products','App\Http\Controllers\ApiController@getCategoryOfProducts');
Route::post('get-product-detail','App\Http\Controllers\ApiController@getProductDetail');
Route::post('get-service-detail','App\Http\Controllers\ApiController@getServiceDetail');
Route::post('get-hotel-detail2','App\Http\Controllers\ApiController@getHotelDetail2');
