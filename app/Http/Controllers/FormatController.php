<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Format;
use App\Models\Account;
use App\Models\User;
use App\Models\ProductInfo;
use App\Models\ServiceInfo;
use Mail;
use Illuminate\Support\Facades\Auth;
class FormatController extends Controller
{
    public function index(){
        if(Auth::user()->role=="hotel-manager"){
    	   $formats=Format::where('associated_hotel_id',Auth::user()->associated_hotel_id)->orWhere('associated_hotel_id',null)->get();
        }
        if(Auth::user()->role=="super-admin"){
           $formats=Format::all();
        }
        
    	return view('admin-panel.formats.index',compact('formats'));
    }
    public function create(){
    	return view('admin-panel.formats.create');
    }
    public function store(Request $request){
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('formats');
        }
    	$format=new Format;
        $format->title=$request->get('title');
        $format->description=$request->get('description');
        if(Auth::user()->role=="hotel-manager"){
            $format->associated_hotel_id=Auth::user()->associated_hotel_id;
        }
    	$format->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Format stored successfully']);
        }
    	return redirect('formats')->with(['message'=>'Format stored successfully']);
    }
    public function edit($id){
    	$format=Format::find($id);
    	return view('admin-panel.formats.edit',compact('format'));
    }
    public function update(Request $request,$id){
    	if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('formats');
        }
    	$format=Format::find($id);
        $format->title=$request->get('title');
        $format->description=$request->get('description');
    	$format->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Format updated successfully']);
        }
    	return redirect('formats')->with(['message'=>'Format updated successfully']);
    }
    public function delete($id){
    	$format=Format::find($id);
    	$format->delete();
    	return redirect('formats')->with(['message'=>'Format deleted successfully']);
    }
    public function emailHotels(){
    	return view('admin-panel.formats.emailhotels');
    }
    public function emailCustomers(){
    	return view('admin-panel.formats.emailcustomers');
    }
    public function sendHotels(Request $request){
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('email-hotel');
        }
    	$format=Format::find($request->get('format'));
        $emailSender=$request->get('email');
        $nameSender=$request->get('name');
    	foreach ($request->get('hotels') as $key => $hotelId) {
    		$hotel=Account::find($hotelId);
    	
    		$description=$format->description;
    		$description=str_replace("hotel_name", $hotel->name, $description);
    		if(!empty($request->get('productId'))){
    			$product=ProductInfo::find($request->get('productId'));
    			$description=str_replace("product_name", $product->name_en, $description);
    		}
    		if(!empty($request->get('serviceId'))){
    			$service=ServiceInfo::find($request->get('serviceId'));
    			$description=str_replace("service_name", $service->name_en, $description);
    		}
    		$email=$hotel->email;
    		Mail::send('mail',['des'=>$description], function($message) use($email,$emailSender,$nameSender){
                 $message->to($email)->subject('Geokge');
                 $message->from($emailSender,$nameSender);          
                });
    	}
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Email sent successfully']);
        }
        return redirect('email-hotels')->with('message','Email sent successfully');
    }
    public function sendCustomers(Request $request){
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('email-customers');
        }
    	$format=Format::find($request->get('format'));
        $emailSender=$request->get('email');
        $nameSender=$request->get('name');
    	//dd($request->get('customers'));
    	foreach ($request->get('customers') as $key => $userId) {
    		$customer=User::find($userId);
    		
    		
    		$description=$format->description;
    		$description=str_replace("customer_name", $customer->name, $description);
    		if(!empty($request->get('productId'))){
    			$product=ProductInfo::find($request->get('productId'));
    			$description=str_replace("product_name", $product->name_en, $description);
    		}
    		if(!empty($request->get('serviceId'))){
    			$service=ServiceInfo::find($request->get('serviceId'));
    			$description=str_replace("service_name", $service->name_en, $description);
    		}
    		$email=$customer->email;
    		Mail::send('mail',['des'=>$description], function($message) use($email,$emailSender,$nameSender){
                 $message->to($email)->subject('Geokge');
                 $message->from($emailSender,$nameSender);
                
                });
    		
    		
    	}
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Email sent successfully']);
        }
        return redirect('email-customers')->with('message','Email sent successfully');
    }
}
