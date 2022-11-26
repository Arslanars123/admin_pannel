<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\ProductInfo;

class BookingController extends Controller
{
    public function bookingsOfUser($customer_id){
    	$bookings=Booking::where('user_id',$customer_id)->orderBy('created_at','desc')->get();
    	return view('admin-panel.customers.bookings',compact('bookings'));
    }
    public function bookingsOfHotel($hotel_id){
    	$products=ProductInfo::where('hotel_id',$hotel_id)->get();
    	$productsIds=array();
    	foreach ($products as $key => $value) {
    		array_push($productsIds,$value->id);
    	}
    	$bookings=Booking::whereIn('product_id',$productsIds)->orderBy('created_at','desc')->get();
    	return view('admin-panel.hotels-accounts.bookings',compact('bookings'));
    }
}
