<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Models\ServiceInfo;
class ReserveController extends Controller
{
    public function reservesOfUser($customer_id){
    	$reserves=Reserve::where('user_id',$customer_id)->orderBy('created_at','desc')->get();
    	return view('admin-panel.customers.reserves',compact('reserves'));
    }
    public function reservesOfHotel($hotel_id){
    	$services=ServiceInfo::where('hotel_id',$hotel_id)->get();
    	$servicesIds=array();
    	foreach ($services as $key => $value) {
    		array_push($servicesIds,$value->id);
    	}
    	$reserves=Reserve::whereIn('service_id',$servicesIds)->orderBy('created_at','desc')->get();
    	return view('admin-panel.customers.reserves',compact('reserves'));
    }
}
