<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerField;
use App\Models\Dropdown;
use Illuminate\Support\Facades\Schema;
use DB;
class CustomerFieldController extends Controller
{
    public function index(){
    	$customerfields=CustomerField::all();
    	return view('admin-panel.customer-fields.index',compact('customerfields'));
    }
    public function create(){
    	return view('admin-panel.customer-fields.create');
    }
    public function store(Request $request){
    	//dd($request->all());
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('customer-fields');
        }
    	$customerfield=new CustomerField;
    	$customerfield->italian_label=$request->get('italian_label');
    	$customerfield->english_label=$request->get('english_label');
    	$customerfield->field_type=$request->get('field_type');
        $customerfield->is_mandatory=$request->get('is_mandatory');
        $customerfield->orderNo=$request->get('orderNo');
    	$customerfield->field_name=strtolower(str_replace(" ","_",$request->get('english_label')));
    	$fieldType=$request->get('field_type');

    	$nam=str_replace(" ","_",$request->get('english_label'));
    	$nam=strtolower($nam);
        $nam_en=$nam."_en";
        $nam_it=$nam."_it";
    	if(Schema::hasColumn("users",$nam_en)||Schema::hasColumn("users",$nam_it)||Schema::hasColumn("users",$nam)){
    		return redirect('customer-fields')->with(['message2'=>'Column already exists']);
    	}
    	if($fieldType=="string"){
    		DB::statement("ALTER TABLE users ADD {$nam_en} VARCHAR(255);");
            DB::statement("ALTER TABLE users ADD {$nam_it} VARCHAR(255);");
    	}
    	if($fieldType=="integer"){
    		DB::statement("ALTER TABLE users ADD {$nam} integer;");
    	}
    	if($fieldType=="date"){
    		DB::statement("ALTER TABLE users ADD {$nam} date;");
    	}
    	if($fieldType=="time"){
    		DB::statement("ALTER TABLE users ADD {$nam} time;");
    	}
    	if($fieldType=="dropdown"){
    		if(empty($request->get('dropdown_items'))){
    			return redirect('customer-fields')->with(['message2'=>'Dropdown Items are missing. Try again with adding items if you want to add dropdown field']);
    		}
    		DB::statement("ALTER TABLE users ADD {$nam} VARCHAR(255);");
    		foreach ($request->get('dropdown_items') as $key => $value) {
    			$dropdown=new Dropdown;
    			$dropdown->table_name="users";
    			$dropdown->column_name=$nam;
    			$dropdown->item_name=$value;
    			$dropdown->save();
    		}
    	}
        if($fieldType=="file"){
            DB::statement("ALTER TABLE users ADD {$nam} VARCHAR(255);");
        }
        if($fieldType=="description"){
            DB::statement("ALTER TABLE users ADD {$nam_en} LONGTEXT;");
            DB::statement("ALTER TABLE users ADD {$nam_it} LONGTEXT;");
        }
    	$customerfield->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Customer information field saved successfully']);
        }
    	return redirect('customer-fields')->with(['message'=>' Customer information field saved successfully']);
    }
    public function edit($id){
    	$customerfield=Customerfield::find($id);
    	return view('admin-panel.customer-fields.edit',compact('customerfield'));
    }
    public function update(Request $request,$id){
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('customer-fields');
        }
        $customerfield=CustomerField::find($id);
        $oldtype=$customerfield->field_type;
        $old=$customerfield->field_name;
        $old_en=$old."_en";
        $old_it=$old."_it";
        
    	$customerfield=CustomerField::find($id);
    	$customerfield->italian_label=$request->get('italian_label');
    	$customerfield->english_label=$request->get('english_label');
        $customerfield->is_mandatory=$request->get('is_mandatory');
        $customerfield->orderNo=$request->get('orderNo');

    	if($customerfield->field_type!=$request->get('field_type')){
    		
	    	$customerfield->field_type=$request->get('field_type');
	    	$customerfield->field_name=strtolower(str_replace(" ","_",$request->get('english_label')));
	    	$fieldType=$request->get('field_type');
	    	$nam=str_replace(" ","_",$request->get('english_label'));
	    	$nam=strtolower($nam);
            $nam_en=$nam."_en";
            $nam_it=$nam."_it";
            if(Schema::hasColumn("users",$nam_en)||Schema::hasColumn("users",$nam_it)||Schema::hasColumn("users",$nam)){
                return redirect('customer-fields')->with(['message2'=>'Column already exists']);
            }
            if($oldtype=="string"||$oldtype=="description"){
                DB::statement('ALTER TABLE users DROP COLUMN {{$old_en}}');
                DB::statement('ALTER TABLE users DROP COLUMN {{$old_it}}');    
            }
            if($oldtype!="string"&&$oldtype!="description"){
                DB::statement('ALTER TABLE users DROP COLUMN {{$old}}');
            }
	    	if($fieldType=="string"){
	    		DB::statement("ALTER TABLE users ADD {$nam_en} VARCHAR(255);");
                DB::statement("ALTER TABLE users ADD {$nam_it} VARCHAR(255);");
	    	}
            if($fieldType=="description"){
                DB::statement("ALTER TABLE users ADD {$nam_en} LONGTEXT;");
                DB::statement("ALTER TABLE users ADD {$nam_it} LONGTEXT;");
            }
	    	if($fieldType=="integer"){
	    		DB::statement("ALTER TABLE users ADD {$nam} integer;");
	    	}
	    	if($fieldType=="date"){
	    		DB::statement("ALTER TABLE users ADD {$nam} date;");
	    	}
	    	if($fieldType=="time"){
	    		DB::statement("ALTER TABLE users ADD {$nam} time;");
	    	}
	    	if($fieldType=="dropdown"){
	    		if(empty($request->get('dropdown_items'))){
                    return redirect('customer-fields')->with(['message2'=>'Dropdown Items are missing. Try again with adding items if you want to add dropdown field']);
                }
                DB::statement("ALTER TABLE users ADD {$nam} VARCHAR(255);");
                $olds=Dropdown::where('table_name','customersinformations')->where('column_name',$name)->get();
                foreach ($olds as $key => $value) {
                    $value->delete();
                }
                foreach ($request->get('dropdown_items') as $key => $value) {
                    $dropdown=new Dropdown;
                    $dropdown->table_name="users";
                    $dropdown->column_name=$nam;
                    $dropdown->item_name=$value;
                    $dropdown->save();
                }
	    	}
            if($fieldType=="file"){
                DB::statement("ALTER TABLE users ADD {$nam} VARCHAR(255);");
            }
    	}
    	$customerfield->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Customer information field updated successfully']);
        }
    	return redirect('customer-fields')->with(['message'=>'Customer information field updated successfully']);
    }
    public function delete($id){
    	$customerfield=CustomerField::find($id);
    	$old=$customerfield->field_name;
        $old_en=$old."_en";
        $old_it=$old."_it";
        if($customerfield->field_type=="string"){
            DB::statement("ALTER TABLE users DROP COLUMN {$old_en}");
            DB::statement("ALTER TABLE users DROP COLUMN {$old_it}");   
        }
        if($customerfield->field_type!="string"){
            DB::statement("ALTER TABLE users DROP COLUMN {$old}");
        }
    	$customerfield->delete();
    	
    	return redirect('customer-fields')->with(['message'=>'Customer information field deleted successfully']);
    }
}
