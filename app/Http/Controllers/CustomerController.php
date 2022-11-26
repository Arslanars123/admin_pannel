<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerField;
use App\Models\CustomerInfo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Input;
use Mail;
class CustomerController extends Controller
{
    public function index($hotel_id){
        if($hotel_id=="all"){
            $customers=User::where('role','customer')->get();
            return view('admin-panel.customers.index',compact('customers','hotel_id'));
        }
    	$customers=User::where('associated_hotel_id',$hotel_id)->where('role','customer')->get();
    	return view('admin-panel.customers.index',compact('customers','hotel_id'));
    }
    public function create($hotel_id){
    	return view('admin-panel.customers.create',compact('hotel_id'));
    }
    public function store(Request $request){
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            /*if(Auth::user()->role=="super-admin"){
                return redirect('customers/'.'all');    
            }*/
            return redirect('customers/'.$request->get('hotel_id'));
        }
    	$fields=CustomerField::all();
    	$customer=new User;
        $customer->name=$request->get('name');
        $customer->email=$request->get('email');
        $customer->password=$request->get('password');
        $customer->phone=$request->get('phone');
        $customer->adults=$request->get('adults');
        $customer->children=$request->get('children');
        $customer->dateFrom=$request->get('dateFrom');
        $customer->dateTo=$request->get('dateTo');
        $customer->language="italian";
        $image=Input::file("image");
        if(!empty($image)){
            $newFilename=$image->getClientOriginalName();
            $destinationPath='customersImages';
            $image->move($destinationPath,$newFilename);
            $picPath='customersImages/' . $newFilename;
            $customer->image=$picPath;
        }

    	foreach ($fields as $key => $field) {
    		if($field->field_type=="string"||$field->field_type=="description"){
    			$nam=$field->field_name;
    			$nam_en=$nam."_en";
    			$nam_it=$nam."_it";	

    			$customer[$nam_en]=$request->get(''.$nam_en);
    			$customer[$nam_it]=$request->get(''.$nam_it);
    		}
    		if($field->field_type!="string"&&$field->field_type!="description"&&$field->field_type!="file"){
    			$nam=$field->field_name;
    			$customer[$nam]=$request->get(''.$nam);
    		}
            if($field->field_type=="file"){
                $nam=$field->field_name;
                $fil=Input::file("".$nam);
                if(!empty($fil)){
                    $newFilename=$fil->getClientOriginalName();
                    $destinationPath='customersFiles';
                    $fil->move($destinationPath,$newFilename);
                    $picPath='customersFiles/' . $newFilename;
                    $customer[$nam]=$picPath;
                }
            }
    		
    	}
    	$customer->associated_hotel_id=$request->get('hotel_id');
        $customer->role="customer";
        
    	$customer->save();
        $customer->reservation_code=rand(1111,9999).'-'.$customer->id;
        $customer->save();
        $email=$customer->email;
            Mail::send('mailr',['code'=>$customer->reservation_code], function($message) use($email){
                 $message->to($email)->subject('Geokge');
                 $message->from('pagoda.app@gmail.com');
                
                });
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Customer stored successfully and reservation code sent to customer email']);
        }
        /*if(Auth::user()->role=="super-admin"){
            return redirect('customers/'.'all')->with(['message'=>'Customer stored successfully']);;    
        }*/
    	return redirect('customers/'.$customer->associated_hotel_id)->with(['message'=>'Customer stored successfully and reservation code sent to customer email']);
    }
    public function edit($id){
    	$customer=User::find($id);
    	return view('admin-panel.customers.edit',compact('customer'));
    }
    public function update(Request $request,$id){
    	$fields=CustomerField::all();
    	$customer=User::find($id);
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            /*if(Auth::user()->role=="super-admin"){
                return redirect('customers/'.'all');    
            }*/
            return redirect('customers/'.$customer->associated_hotel_id);
        }
        $customer->name=$request->get('name');
        $customer->email=$request->get('email');
        $customer->password=$request->get('password');
        $customer->phone=$request->get('phone');
        $customer->adults=$request->get('adults');
        $customer->children=$request->get('children');
        $customer->dateFrom=$request->get('dateFrom');
        $customer->dateTo=$request->get('dateTo');
        $image=Input::file("image");
        if(!empty($image)){
            $newFilename=$image->getClientOriginalName();
            $destinationPath='customersImages';
            $image->move($destinationPath,$newFilename);
            $picPath='customersImages/' . $newFilename;
            $customer->image=$picPath;
        }

    	foreach ($fields as $key => $field) {
    		if($field->field_type=="string"||$field->field_type=="description"){
                $nam=$field->field_name;
                $nam_en=$nam."_en";
                $nam_it=$nam."_it"; 

                $customer[$nam_en]=$request->get(''.$nam_en);
                $customer[$nam_it]=$request->get(''.$nam_it);
            }
            if($field->field_type!="string"&&$field->field_type!="description"&&$field->field_type!="file"){
                $nam=$field->field_name;
                $customer[$nam]=$request->get(''.$nam);
            }
            if($field->field_type=="file"){
                $nam=$field->field_name;
                $fil=Input::file("".$nam);
                if(!empty($fil)){
                    $newFilename=$fil->getClientOriginalName();
                    $destinationPath='customersFiles';
                    $fil->move($destinationPath,$newFilename);
                    $picPath='customersFiles/' . $newFilename;
                    $customer[$nam]=$picPath;
                }
            }
    	}
    	$customer->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Customer updated successfully']);
        }
        /*if(Auth::user()->role=="super-admin"){
            return redirect('customers/'.'all')->with(['message'=>'Customer updated successfully']);    
        }*/
    	return redirect('customers/'.$customer->associated_hotel_id)->with(['message'=>'Customer updated successfully']);
    }
    public function delete($id){
    	$customer=User::find($id);
        $hotel_id=$customer->associated_hotel_id;
    	$customer->delete();
    	return redirect('customers/'.$hotel_id)->with(['message'=>'Customer deleted successfully']);
    }
}
