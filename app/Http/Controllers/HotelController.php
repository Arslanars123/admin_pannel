<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
class HotelController extends Controller
{
    public function index(){
    	$accounts=Account::all();
    	return view('admin-panel.hotels-accounts.index',compact('accounts'));
    }
    public function create(){
    	return view('admin-panel.hotels-accounts.create');
    }
    public function store(Request $request){
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('hotels-accounts');
        }
    	$emailExists=User::where('email',$request->get('email'))->exists();
    	if($emailExists==true){
    		return redirect()->back()->with(['message2'=>'Email already exists']);
    	}
    	$hotelExists=Account::where('name',$request->get('name'))->exists();
    	if($hotelExists==true){
    		return redirect()->back()->with(['message2'=>'Hotel name already exists']);
    	}
    	$account=new Account;
    	$account->email=$request->get('email');
    	$account->password=$request->get('password');
    	$account->name=$request->get('name');
    	$account->save();

    	$user=new User;
    	$user->email=$request->get('email');
    	$user->password=$request->get('password');
    	$user->name=$request->get('name');
    	$user->role="hotel-manager";
    	$user->associated_hotel_id=$account->id;

    	$user->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Hotel account saved successfully']);
        }
    	return redirect('hotels-accounts')->with(['message'=>'Hotel account saved successfully']);
    }
    public function edit($id){
    	$account=Account::find($id);
    	return view('admin-panel.hotels-accounts.edit',compact('account'));
    }
    public function update(Request $request,$id){
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('hotels-accounts');
        }
    	$account=Account::find($id);
    	$user=User::where('associated_hotel_id',$id)->first();
    	if($account->email!=$request->get('email')){
    		$emailExists=User::where('email',$request->get('email'))->exists();
	    	if($emailExists==true){
	    		return redirect()->back()->with(['message2'=>'Email already exists']);
	    	}
    		$account->email=$request->get('email');
    		$user->email=$request->get('email');
    	}
    	if($account->password!=$request->get('password')){
    		$account->password=$request->get('password');
    		$user->password=$request->get('password');
    	}
    	if($account->name!=$request->get('name')){
    		$hotelExists=Account::where('name',$request->get('name'))->exists();
	    	if($hotelExists==true){
	    		return redirect()->back()->with(['message2'=>'Hotel name already exists']);
	    	}
    		$account->name=$request->get('name');
    	}
    	$user->save();
    	$account->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Hotel account saved successfully']);
        }
    	return redirect('hotels-accounts')->with(['message'=>'Hotel account updated successfully']);
    }
    public function delete($id){
    	$account=Account::find($id);
    	$account->delete();
    	$user=User::where('associated_hotel_id',$id)->first();
    	$user->delete();
    	return redirect('hotels-accounts')->with(['message'=>'Hotel account deleted successfully']);
    }
}
