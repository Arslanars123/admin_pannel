<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductField;
use App\Models\Dropdown;
use Illuminate\Support\Facades\Schema;
use DB;
class ProductFieldController extends Controller
{
    public function index(){
    	$productfields=ProductField::all();
    	return view('admin-panel.product-fields.index',compact('productfields'));
    }
    public function create(){
    	return view('admin-panel.product-fields.create');
    }
    public function store(Request $request){
    	//dd($request->all());
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('product-fields');
        }
    	$productfield=new ProductField;
    	$productfield->italian_label=$request->get('italian_label');
    	$productfield->english_label=$request->get('english_label');
    	$productfield->field_type=$request->get('field_type');
        $productfield->is_mandatory=$request->get('is_mandatory');
        $productfield->orderNo=$request->get('orderNo');
    	$productfield->field_name=strtolower(str_replace(" ","_",$request->get('english_label')));
    	$fieldType=$request->get('field_type');

    	$nam=str_replace(" ","_",$request->get('english_label'));
    	$nam=strtolower($nam);
        $nam_en=$nam."_en";
        $nam_it=$nam."_it";
    	if(Schema::hasColumn("productsinformations",$nam)||Schema::hasColumn("productsinformations",$nam_en)||Schema::hasColumn("productsinformations",$nam_it)){
    		return redirect('product-fields')->with(['message2'=>'Column already exists']);
    	}
    	if($fieldType=="string"){
    		DB::statement("ALTER TABLE productsinformations ADD {$nam_en} VARCHAR(255);");
            DB::statement("ALTER TABLE productsinformations ADD {$nam_it} VARCHAR(255);");
    	}
    	if($fieldType=="integer"){
    		DB::statement("ALTER TABLE productsinformations ADD {$nam} integer;");
    	}
    	if($fieldType=="date"){
    		DB::statement("ALTER TABLE productsinformations ADD {$nam} date;");
    	}
    	if($fieldType=="time"){
    		DB::statement("ALTER TABLE productsinformations ADD {$nam} time;");
    	}
    	if($fieldType=="dropdown"){
    		if(empty($request->get('dropdown_items'))){
    			return redirect('product-fields')->with(['message2'=>'Dropdown Items are missing. Try again with adding items if you want to add dropdown field']);
    		}
    		DB::statement("ALTER TABLE productsinformations ADD {$nam} VARCHAR(255);");
    		foreach ($request->get('dropdown_items') as $key => $value) {
    			$dropdown=new Dropdown;
    			$dropdown->table_name="productsinformations";
    			$dropdown->column_name=$nam;
    			$dropdown->item_name=$value;
    			$dropdown->save();
    		}
    	}
        if($fieldType=="file"){
            DB::statement("ALTER TABLE productsinformations ADD {$nam} VARCHAR(255);");
        }
        if($fieldType=="description"){
            DB::statement("ALTER TABLE productsinformations ADD {$nam_en} LONGTEXT;");
            DB::statement("ALTER TABLE productsinformations ADD {$nam_it} LONGTEXT;");
        }
    	$productfield->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Product information field saved successfully']);
        }

    	return redirect('product-fields')->with(['message'=>'Product information field saved successfully']);
    }
    public function edit($id){
    	$productfield=Productfield::find($id);
    	return view('admin-panel.product-fields.edit',compact('productfield'));
    }
    public function update(Request $request,$id){
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('product-fields');
        }
        $oldtype=$productfield->field_type;
        $old=$productfield->field_name;
        $old_en=$old."_en";
        $old_it=$old."_it";

    	$productfield=ProductField::find($id);
    	$productfield->italian_label=$request->get('italian_label');
    	$productfield->english_label=$request->get('english_label');
        $productfield->is_mandatory=$request->get('is_mandatory');
        $productfield->orderNo=$request->get('orderNo');

    	if($productfield->field_type!=$request->get('field_type')){

	    	$productfield->field_type=$request->get('field_type');
	    	$productfield->field_name=strtolower(str_replace(" ","_",$request->get('english_label')));
	    	$fieldType=$request->get('field_type');
	    	$nam=str_replace(" ","_",$request->get('english_label'));
	    	$nam=strtolower($nam);
            $nam_en=$nam."_en";
            $nam_it=$nam."_it";
            if(Schema::hasColumn("productsinformations",$nam)||Schema::hasColumn("productsinformations",$nam_en)||Schema::hasColumn("productsinformations",$nam_it)){
                return redirect('product-fields')->with(['message2'=>'Column already exists']);
            }
            if($oldtype=="string"||$oldtype=="description"){
                DB::statement("ALTER TABLE productsinformations DROP COLUMN {$old_en}");
                DB::statement("ALTER TABLE productsinformations DROP COLUMN {$old_it}");    
            }
            if($oldtype!="string"&&$oldtype!="description"){
                DB::statement("ALTER TABLE customersinformations DROP COLUMN {$old}");
            }
	    	if($fieldType=="string"){
	    		DB::statement("ALTER TABLE productsinformations ADD {$nam_en} VARCHAR(255);");
                DB::statement("ALTER TABLE productsinformations ADD {$nam_it} VARCHAR(255);");
	    	}
            if($fieldType=="description"){
                DB::statement("ALTER TABLE productsinformations ADD {$nam_en} LONGTEXT;");
                DB::statement("ALTER TABLE productsinformations ADD {$nam_it} LONGTEXT;");
            }
	    	if($fieldType=="integer"){
	    		DB::statement("ALTER TABLE productsinformations ADD {$nam} integer;");
	    	}
	    	if($fieldType=="date"){
	    		DB::statement("ALTER TABLE productsinformations ADD {$nam} date;");
	    	}
	    	if($fieldType=="time"){
	    		DB::statement("ALTER TABLE productsinformations ADD {$nam} time;");
	    	}
	    	if($fieldType=="dropdown"){
                if(empty($request->get('dropdown_items'))){
                    return redirect('product-fields')->with(['message2'=>'Dropdown Items are missing. Try again with adding items if you want to add dropdown field']);
                }
                DB::statement("ALTER TABLE productsinformations ADD {$nam} VARCHAR(255);");
                $olds=Dropdown::where('table_name','productsinformations')->where('column_name',$name)->get();
                foreach ($olds as $key => $value) {
                    $value->delete();
                }
	    		DB::statement("ALTER TABLE productsinformations ADD {$nam} VARCHAR(255);");
	    	}
            if($fieldType=="file"){
                DB::statement("ALTER TABLE productsinformations ADD {$nam} VARCHAR(255);");
            }
    	}
    	$productfield->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Product information field updated successfully']);
        }
    	return redirect('product-fields')->with(['message'=>'Product information field updated successfully']);
    }
    public function delete($id){
    	$productfield=ProductField::find($id);
    	$old=$productfield->field_name;
        $old_en=$old."_en";
        $old_it=$old."_it";
        if($productfield->field_type=="string"){
            DB::statement("ALTER TABLE productsinformations DROP COLUMN {$old_en}");
            DB::statement("ALTER TABLE productsinformations DROP COLUMN {$old_it}");   
        }
        if($productfield->field_type!="string"){
            DB::statement("ALTER TABLE productsinformations DROP COLUMN {$old}");
        }
    	DB::statement("ALTER TABLE productsinformations DROP COLUMN {$old}");
    	$productfield->delete();
    	
    	return redirect('product-fields')->with(['message'=>'Product information field deleted successfully']);
    }
}
