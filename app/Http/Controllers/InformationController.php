<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoField;
use App\Models\HotelInfo;
use Illuminate\Support\Facades\Auth;
use Input;
class InformationController extends Controller
{
    public function index($hotel_id){
    	$exists=HotelInfo::where('hotel_id',$hotel_id)->exists();
    	if($exists==false){
    		$information=new HotelInfo;
    		$information->hotel_id=$hotel_id;
    		$information->save();
    		return view('admin-panel.informations.edit',compact('information'));
    	}
    	if($exists==true){

    		$information=HotelInfo::where('hotel_id',$hotel_id)->first();
    		
    		return view('admin-panel.informations.edit',compact('information'));	
    	}
    }
    public function update(Request $request,$id){
        //dd($request->all());
    	$fields=InfoField::all();
    	$information=HotelInfo::find($id);
        $information->name_en=$request->get('name_en');
        $information->name_it=$request->get('name_it');
        $image=Input::file("image");
        if(!empty($image)){
            $newFilename=$image->getClientOriginalName();
            $destinationPath='informationsImages';
            $image->move($destinationPath,$newFilename);
            $picPath='informationsImages/' . $newFilename;
            $information->image=$picPath;
        }
        $logo=Input::file("logo");
        if(!empty($logo)){
            $newFilename=$logo->getClientOriginalName();
            $destinationPath='informationsImages';
            $logo->move($destinationPath,$newFilename);
            $picPath='informationsImages/' . $newFilename;
            $information->logo=$picPath;
        }
		$information->showNameOrImage=$request->get('showNameOrImage');
    	foreach ($fields as $key => $field) {
    		if($field->field_type=="string"||$field->field_type=="description"){
    			$nam=$field->field_name;
    			$nam_en=$nam."_en";
    			$nam_it=$nam."_it";	

    			$information[$nam_en]=$request->get(''.$nam_en);
    			$information[$nam_it]=$request->get(''.$nam_it);
    		}
    		if($field->field_type!="string"&&$field->field_type!="description"&&$field->field_type!="file"){
    			$nam=$field->field_name;
    			$information[$nam]=$request->get(''.$nam);
    		}
            if($field->field_type=="file"){
                $nam=$field->field_name;
                $fil=Input::file("".$nam);
                if(!empty($fil)){
                    $newFilename=$fil->getClientOriginalName();
                    $destinationPath='informationsFiles';
                    $fil->move($destinationPath,$newFilename);
                    $picPath='informationsFiles/' . $newFilename;
                    $information[$nam]=$picPath;
                }
            }
    	}
    	$information->save();
    	return redirect('informations/'.$information->hotel_id)->with(['message'=>'Hotel information updated successfully']);
    }
}
