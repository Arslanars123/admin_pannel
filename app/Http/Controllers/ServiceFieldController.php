<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceField;
use App\Models\Dropdown;
use Illuminate\Support\Facades\Schema;
use DB;
class ServiceFieldController extends Controller
{
    public function index(){
    	$servicefields=ServiceField::all();
    	return view('admin-panel.service-fields.index',compact('servicefields'));
    }
    public function create(){
    	return view('admin-panel.service-fields.create');
    }
    public function store(Request $request){
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('service-fields');
        }
    	//dd($request->all());
    	$servicefield=new ServiceField;
    	$servicefield->italian_label=$request->get('italian_label');
    	$servicefield->english_label=$request->get('english_label');
    	$servicefield->field_type=$request->get('field_type');
        $servicefield->is_mandatory=$request->get('is_mandatory');
        $servicefield->orderNo=$request->get('orderNo');
    	$servicefield->field_name=strtolower(str_replace(" ","_",$request->get('english_label')));
    	$fieldType=$request->get('field_type');

    	$nam=str_replace(" ","_",$request->get('english_label'));
    	$nam=strtolower($nam);
        $nam_en=$nam."_en";
        $nam_it=$nam."_it";
    	if(Schema::hasColumn("servicesinformations",$nam)||Schema::hasColumn("servicesinformations",$nam_en)||Schema::hasColumn("servicesinformations",$nam_it)){
    		return redirect('service-fields')->with(['message2'=>'Column already exists']);
    	}
    	if($fieldType=="string"){
    		DB::statement("ALTER TABLE servicesinformations ADD {$nam_en} VARCHAR(255);");
            DB::statement("ALTER TABLE servicesinformations ADD {$nam_it} VARCHAR(255);");
    	}
    	if($fieldType=="integer"){
    		DB::statement("ALTER TABLE servicesinformations ADD {$nam} integer;");
    	}
    	if($fieldType=="date"){
    		DB::statement("ALTER TABLE servicesinformations ADD {$nam} date;");
    	}
    	if($fieldType=="time"){
    		DB::statement("ALTER TABLE servicesinformations ADD {$nam} time;");
    	}
    	if($fieldType=="dropdown"){
    		if(empty($request->get('dropdown_items'))){
    			return redirect('service-fields')->with(['message2'=>'Dropdown Items are missing. Try again with adding items if you want to add dropdown field']);
    		}
    		DB::statement("ALTER TABLE servicesinformations ADD {$nam} VARCHAR(255);");
    		foreach ($request->get('dropdown_items') as $key => $value) {
    			$dropdown=new Dropdown;
    			$dropdown->table_name="servicesinformations";
    			$dropdown->column_name=$nam;
    			$dropdown->item_name=$value;
    			$dropdown->save();
    		}
    	}
        if($fieldType=="file"){
            DB::statement("ALTER TABLE servicesinformations ADD {$nam} VARCHAR(255);");
        }
        if($fieldType=="description"){
            DB::statement("ALTER TABLE servicesinformations ADD {$nam_en} LONGTEXT;");
            DB::statement("ALTER TABLE servicesinformations ADD {$nam_it} LONGTEXT;");
        }
    	$servicefield->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Service information field saved successfully']);
        }
    	return redirect('service-fields')->with(['message'=>'Service information field saved successfully']);
    }
    public function edit($id){
    	$servicefield=ServiceField::find($id);
    	return view('admin-panel.hotels-accounts.edit',compact('servicefield'));
    }
    public function update(Request $request,$id){
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('service-fields');
        }
        $oldtype=$servicefield->field_type;
        $old=$servicefield->field_name;
        $old_en=$old."_en";
        $old_it=$old."_it";

    	$servicefield=ServiceField::find($id);
    	$servicefield->italian_label=$request->get('italian_label');
    	$servicefield->english_label=$request->get('english_label');
        $servicefield->is_mandatory=$request->get('is_mandatory');
        $servicefield->orderNo=$request->get('orderNo');

    	if($servicefield->field_type!=$request->get('field_type')){
    		

	    	$servicefield->field_type=$request->get('field_type');
	    	$servicefield->field_name=strtolower(str_replace(" ","_",$request->get('english_label')));
	    	$fieldType=$request->get('field_type');
	    	$nam=str_replace(" ","_",$request->get('english_label'));
	    	$nam=strtolower($nam);
            $nam_en=$nam."_en";
            $nam_it=$nam."_it";
            if(Schema::hasColumn("servicesinformations",$nam)||Schema::hasColumn("servicesinformations",$nam_en)||Schema::hasColumn("servicesinformations",$nam_it)){
                return redirect('service-fields')->with(['message2'=>'Column already exists']);
            }
            if($oldtype=="string"||$oldtype=="description"){
                DB::statement("ALTER TABLE servicesinformations DROP COLUMN {$old_en}");
                DB::statement("ALTER TABLE servicesinformations DROP COLUMN {$old_it}");    
            }
            if($oldtype!="string"&&$oldtype!="description"){
                DB::statement("ALTER TABLE servicesinformations DROP COLUMN {$old}");
            }
	    	if($fieldType=="string"){
	    		DB::statement("ALTER TABLE servicesinformations ADD {$nam_en} VARCHAR(255);");
                DB::statement("ALTER TABLE servicesinformations ADD {$nam_it} VARCHAR(255);");
	    	}
            if($fieldType=="description"){
                DB::statement("ALTER TABLE servicesinformations ADD {$nam_en} LONGTEXT;");
                DB::statement("ALTER TABLE servicesinformations ADD {$nam_it} LONGTEXT;");
            }
	    	if($fieldType=="integer"){
	    		DB::statement("ALTER TABLE servicesinformations ADD {$nam} integer;");
	    	}
	    	if($fieldType=="date"){
	    		DB::statement("ALTER TABLE servicesinformations ADD {$nam} date;");
	    	}
	    	if($fieldType=="time"){
	    		DB::statement("ALTER TABLE servicesinformations ADD {$nam} time;");
	    	}
	    	if($fieldType=="dropdown"){
                if(empty($request->get('dropdown_items'))){
                    return redirect('service-fields')->with(['message2'=>'Dropdown Items are missing. Try again with adding items if you want to add dropdown field']);
                }
                DB::statement("ALTER TABLE servicesinformations ADD {$nam} VARCHAR(255);");
                $olds=Dropdown::where('table_name','servicesinformations')->where('column_name',$name)->get();
                foreach ($olds as $key => $value) {
                    $value->delete();
                }
	    		DB::statement("ALTER TABLE servicesinformations ADD {$nam} VARCHAR(255);");
	    	}
            if($fieldType=="file"){
                DB::statement("ALTER TABLE servicesinformations ADD {$nam} VARCHAR(255);");
            }
    	}
    	$servicefield->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Service information field updated successfully']);
        }
    	return redirect('service-fields')->with(['message'=>'Service information field updated successfully']);
    }
    public function delete($id){
    	$servicefield=ServiceField::find($id);
    	$old=$servicefield->field_name;
        $old_en=$old."_en";
        $old_it=$old."_it";
        if($servicefield->field_type=="string"){
            DB::statement("ALTER TABLE servicesinformations DROP COLUMN {$old_en}");
            DB::statement("ALTER TABLE servicesinformations DROP COLUMN {$old_it}");   
        }
        if($servicefield->field_type!="string"){
            DB::statement("ALTER TABLE servicesinformations DROP COLUMN {$old}");
        }
    	DB::statement("ALTER TABLE servicesinformations DROP COLUMN {$old}");
    	$servicefield->delete();
    	
    	return redirect('service-fields')->with(['message'=>'Service information field deleted successfully']);
    }
}
