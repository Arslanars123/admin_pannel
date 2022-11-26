<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductInfo;
use App\Models\ServiceInfo;
use App\Models\Booking;
use App\Models\Reserve;
use Illuminate\Support\Facades\Auth;
use Input;
class CategoryController extends Controller
{
    public function index($hotel_id){
        if($hotel_id=="all"){
            $categories=Category::all();
            return view('admin-panel.categories.index',compact('categories','hotel_id'));
        }
    	$categories=Category::where('hotel_id',$hotel_id)->get();
    	return view('admin-panel.categories.index',compact('categories','hotel_id'));
    }
    public function create($hotel_id){
    	return view('admin-panel.categories.create',compact('hotel_id'));
    }
    public function store(Request $request){
    	if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('categories/'.$request->get('hotel_id'));
        }
    	$categoryExists=Category::where('name_en',$request->get('name_en'))->where('name_it',$request->get('name_it'))->where('type',$request->get('type'))->exists();
    	if($categoryExists==true){
    		return redirect()->back()->with(['message2'=>'Category name already exists']);
    	}
    	$category=new Category;
    	$category->name_en=$request->get('name_en');
        $category->name_it=$request->get('name_it');
    	$category->type=$request->get('type');
    	$category->hotel_id=$request->get('hotel_id');

        $image=Input::file("image");
        if(!empty($image)){
            $newFilename=$image->getClientOriginalName();
            $destinationPath='categoriesImages';
            $image->move($destinationPath,$newFilename);
            $picPath='categoriesImages/' . $newFilename;
            $category->image=$picPath;
        }
    	$category->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Category saved successfully']);
        }
    	return redirect('categories/'.$category->hotel_id)->with(['message'=>'Category saved successfully']);
    }
    public function edit($id){
    	$category=Category::find($id);
    	return view('admin-panel.categories.edit',compact('category'));
    }
    public function update(Request $request,$id){
    	$category=Category::find($id);
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('categories/'.$category->hotel_id);
        }
        if($category->name_en==$request->get('name_en')){
            $category->name_en=$request->get('name_en');
            $category->name_it=$request->get('name_it');
            $image=Input::file("image");
            if(!empty($image)){
                $newFilename=$image->getClientOriginalName();
                $destinationPath='categoriesImages';
                $image->move($destinationPath,$newFilename);
                $picPath='categoriesImages/' . $newFilename;
                $category->image=$picPath;
            }
            $category->save();
            if($request->get('sav')=="SAVE AND STAY"){
                return redirect()->back()->with(['message'=>'Category update successfully']);
            }
            return redirect('categories/'.$category->hotel_id)->with(['message'=>'Category updated successfully']);
        }
    	if($category->name_en!=$request->get('name_en')){
    		$categoryExists=Category::where('name_en',$request->get('name_en'))->where('name_it',$request->get('name_it'))->where('type',$category->type)->exists();
	    	if($categoryExists==true){
	    		return redirect()->back()->with(['message2'=>'Category name already exists']);
	    	}
    		$category->name_en=$request->get('name_en');
            $category->name_it=$request->get('name_it');
            $image=Input::file("image");
            if(!empty($image)){
                $newFilename=$image->getClientOriginalName();
                $destinationPath='categoriesImages';
                $image->move($destinationPath,$newFilename);
                $picPath='categoriesImages/' . $newFilename;
                $category->image=$picPath;
            }
    		$category->save();
            if($request->get('sav')=="SAVE AND STAY"){
                return redirect()->back()->with(['message'=>'Category updated successfully']);
            }
            return redirect('categories/'.$category->hotel_id)->with(['message'=>'Category updated successfully']);
    	}
    	
    }
    public function delete($id){
    	$category=Category::find($id);
    	$hotel_id=$category->hotel_id;
        $category->delete();
        $products=ProductInfo::where('category_id',$id)->get();
        foreach ($products as $key => $value) {
            $bookings=Booking::where('product_id',$value->id)->get();
            foreach ($bookings as $key => $value2) {
                $value2->delete();
            }
            $value->delete();
        }
        $services=ServiceInfo::where('category_id',$id)->get();
        foreach ($services as $key => $value) {
            $reserves=Reserve::where('service_id',$value->id)->get();
            foreach ($reserves as $key => $value2) {
                $value2->delete();
            }
            $value->delete();
        }

    	return redirect('categories/'.$hotel_id)->with(['message'=>'Category deleted successfully']);
    }
}
