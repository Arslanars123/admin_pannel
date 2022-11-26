<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceField;
use App\Models\ServiceInfo;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Input;
class ServiceController extends Controller
{
    public function index($catId){
    	$services=ServiceInfo::where('category_id',$catId)->get();
    	return view('admin-panel.services.index',compact('services','catId'));
    }
    public function create($catId){
    	return view('admin-panel.services.create',compact('catId'));
    }
    public function store(Request $request){
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('services/'.$request->get('catId'));
        }
        $category=Category::find($request->get('catId'));
    	$fields=ServiceField::all();
    	$service=new ServiceInfo;
        $service->name_en=$request->get('name_en');
        $service->name_it=$request->get('name_it');
        $service->price=$request->get('price');
        $image=Input::file("image");
        if(!empty($image)){
            $newFilename=$image->getClientOriginalName();
            $destinationPath='servicesImages';
            $image->move($destinationPath,$newFilename);
            $picPath='servicesImages/' . $newFilename;
            $service->image=$picPath;
        }

        $images=Input::file("images");

        if(!empty($images)){
            foreach ($images as $key => $image) {
                if(!empty($image)){
                    $newFilename=$image->getClientOriginalName();
                    $destinationPath='serviceImages';
                    $image->move($destinationPath,$newFilename);
                    $picPath='serviceImages/' . $newFilename;
                    $imar[$key]=$picPath;
                }
            }
            if(!empty($imar)){
                $service->images=$imar;
            }
        }

    	foreach ($fields as $key => $field) {
    		if($field->field_type=="string"||$field->field_type=="description"){
    			$nam=$field->field_name;
    			$nam_en=$nam."_en";
    			$nam_it=$nam."_it";	

    			$service[$nam_en]=$request->get(''.$nam_en);
    			$service[$nam_it]=$request->get(''.$nam_it);
    		}
    		if($field->field_type!="string"&&$field->field_type!="description"&&$field->field_type!="file"){
    			$nam=$field->field_name;
    			$service[$nam]=$request->get(''.$nam);
    		}
            if($field->field_type=="file"){

                $nam=$field->field_name;
                $fil=Input::file("".$nam);
                if(!empty($fil)){
                    $newFilename=$fil->getClientOriginalName();
                    $destinationPath='serviceFiles';
                    $fil->move($destinationPath,$newFilename);
                    $picPath='serviceFiles/' . $newFilename;
                    $service[$nam]=$picPath;
                }
            }
    		
    	}
    	$service->hotel_id=$category->hotel_id;
    	$service->category_id=$request->get('catId');
    	$service->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Service saved successfully']);
        }
    	return redirect('services/'.$service->category_id)->with(['message'=>'Service stored successfully']);
    }
    public function edit($id){
    	$service=ServiceInfo::find($id);
    	return view('admin-panel.services.edit',compact('service'));
    }
    public function update(Request $request,$id){
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('services/'.$service->category_id);
        }
    	$fields=serviceField::all();
    	$service=ServiceInfo::find($id);
        $service->name_en=$request->get('name_en');
        $service->name_it=$request->get('name_it');
        $service->price=$request->get('price');
        $image=Input::file("image");
        if(!empty($image)){
            $newFilename=$image->getClientOriginalName();
            $destinationPath='servicesImages';
            $image->move($destinationPath,$newFilename);
            $picPath='servicesImages/' . $newFilename;
            $service->image=$picPath;
        }
        $images=Input::file("images");
       
        if(!empty($images)){
            foreach ($images as $key => $image) {
                if(!empty($image)){
                    $newFilename=$image->getClientOriginalName();
                    $destinationPath='serviceImages';
                    $image->move($destinationPath,$newFilename);
                    $picPath='serviceImages/' . $newFilename;
                    $imar[$key]=$picPath;
                }
            }
            if(!empty($imar)){
                $service->images=$imar;
            }
        }

    	foreach ($fields as $key => $field) {
    		if($field->field_type=="string"||$field->field_type=="description"){
                $nam=$field->field_name;
                $nam_en=$nam."_en";
                $nam_it=$nam."_it"; 

                $service[$nam_en]=$request->get(''.$nam_en);
                $service[$nam_it]=$request->get(''.$nam_it);
            }
            if($field->field_type!="string"&&$field->field_type!="description"&&$field->field_type!="file"){
                $nam=$field->field_name;
                $service[$nam]=$request->get(''.$nam);
            }
            if($field->field_type=="file"){
                $nam=$field->field_name;
                $fil=Input::file("".$nam);
                $newFilename=$fil->getClientOriginalName();
                $destinationPath='serviceFiles';
                $fil->move($destinationPath,$newFilename);
                $picPath='serviceFiles/' . $newFilename;
                $service[$nam]=$picPath;
            }
    	}
    	$service->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Service updated successfully']);
        }
    	return redirect('services/'.$service->category_id)->with(['message'=>'Service updated successfully']);
    }
    public function delete($id){
    	$service=ServiceInfo::find($id);
        $category_id=$service->category_id;
    	$service->delete();
    	return redirect('services/'.$category_id)->with(['message'=>'Service deleted successfully']);
    }
}
