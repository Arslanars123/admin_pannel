<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductField;
use App\Models\ProductInfo;
use Illuminate\Support\Facades\Auth;
use Input;
use App\Models\Category;
class ProductController extends Controller
{
     public function index($catId){
    	$products=ProductInfo::where('category_id',$catId)->get();
        
    	return view('admin-panel.products.index',compact('products','catId'));
    }
    public function create($catId){
    	return view('admin-panel.products.create',compact('catId'));
    }
    public function store(Request $request){
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('products/'.$request->get('catId'));
        }
        $category=Category::find($request->get('catId'));
    	$fields=ProductField::all();
    	$product=new ProductInfo;
        $product->name_en=$request->get('name_en');
        $product->name_it=$request->get('name_it');
        $product->price=$request->get('price');
        $image=Input::file("image");
        if(!empty($image)){
            $newFilename=$image->getClientOriginalName();
            $destinationPath='productsImages';
            $image->move($destinationPath,$newFilename);
            $picPath='productsImages/' . $newFilename;
            $product->image=$picPath;
        }

        $images=Input::file("images");
        if(!empty($images)){
            foreach ($images as $key => $image) {
                if(!empty($image)){
                    $newFilename=$image->getClientOriginalName();
                    $destinationPath='productImages';
                    $image->move($destinationPath,$newFilename);
                    $picPath='productImages/' . $newFilename;
                    $imar[$key]=$picPath;
                }
            }
            if(!empty($imar)){
                $product->images=$imar;
            }
        }
    	foreach ($fields as $key => $field) {
    		if($field->field_type=="string"||$field->field_type=="description"){
    			$nam=$field->field_name;
    			$nam_en=$nam."_en";
    			$nam_it=$nam."_it";	

    			$product[$nam_en]=$request->get(''.$nam_en);
    			$product[$nam_it]=$request->get(''.$nam_it);
    		}
    		if($field->field_type!="string"&&$field->field_type!="description"&&$field->field_type!="file"){
    			$nam=$field->field_name;
    			$product[$nam]=$request->get(''.$nam);
    		}
            if($field->field_type=="file"){
                $nam=$field->field_name;
                $fil=Input::file("".$nam);
                if(!empty($fil)){
                    $newFilename=$fil->getClientOriginalName();
                    $destinationPath='productsFiles';
                    $fil->move($destinationPath,$newFilename);
                    $picPath='productsFiles/' . $newFilename;
                    $product[$nam]=$picPath;
                }
            }
    		
    	}
    	$product->hotel_id=$category->hotel_id;
    	$product->category_id=$request->get('catId');
    	$product->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Product stored successfully']);
        }
    	return redirect('products/'.$product->category_id)->with(['message'=>'Product stored successfully']);
    }
    public function edit($id){
    	$product=ProductInfo::find($id);
    	return view('admin-panel.products.edit',compact('product'));
    }
    public function update(Request $request,$id){
    	$fields=ProductField::all();
    	$product=ProductInfo::find($id);
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('products/'.$product->category_id);
        }
        $product->name_en=$request->get('name_en');
        $product->name_it=$request->get('name_it');
        $product->price=$request->get('price');
        $image=Input::file("image");
        if(!empty($image)){
            $newFilename=$image->getClientOriginalName();
            $destinationPath='productsImages';
            $image->move($destinationPath,$newFilename);
            $picPath='productsImages/' . $newFilename;
            $product->image=$picPath;
        }
        $images=Input::file("images");
        if(!empty($images)){
            foreach ($images as $key => $image) {
                if(!empty($image)){
                    $newFilename=$image->getClientOriginalName();
                    $destinationPath='productImages';
                    $image->move($destinationPath,$newFilename);
                    $picPath='productImages/' . $newFilename;
                    $imar[$key]=$picPath;
                }
            }
            if(!empty($imar)){
                $product->images=$imar;
            }
        }
    	foreach ($fields as $key => $field) {
    		if($field->field_type=="string"||$field->field_type=="description"){
                $nam=$field->field_name;
                $nam_en=$nam."_en";
                $nam_it=$nam."_it"; 

                $product[$nam_en]=$request->get(''.$nam_en);
                $product[$nam_it]=$request->get(''.$nam_it);
            }
            if($field->field_type!="string"&&$field->field_type!="description"&&$field->field_type!="file"){
                $nam=$field->field_name;
                $product[$nam]=$request->get(''.$nam);
            }
            if($field->field_type=="file"){
                $nam=$field->field_name;
                $fil=Input::file("".$nam);
                if(!empty($fil)){
                    $newFilename=$fil->getClientOriginalName();
                    $destinationPath='productsFiles';
                    $fil->move($destinationPath,$newFilename);
                    $picPath='productsFiles/' . $newFilename;
                    $product[$nam]=$picPath;
                }
            }
    	}
    	$product->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Product updated successfully']);
        }
    	return redirect('products/'.$product->category_id)->with(['message'=>'Product updated successfully']);
    }
    public function delete($id){
    	$product=ProductInfo::find($id);
        $catId=$product->category_id;
    	$product->delete();
    	return redirect('products/'.$catId)->with(['message'=>'Product deleted successfully']);
    }
}
