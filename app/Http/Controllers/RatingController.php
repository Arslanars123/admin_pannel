<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
class RatingController extends Controller
{
    public function ratingsOfHotel($hotel_id){
    	$ratings=Rating::where('hotel_id',$hotel_id)->get();
    	return view('admin-panel.hotels-accounts.ratings',compact('ratings'));
    }
}
