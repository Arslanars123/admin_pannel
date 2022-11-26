<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoField;
use App\Models\Hotelinfo;
use App\Models\Dropdown;
use Illuminate\Support\Facades\Schema;
use DB;
class InfoFieldController extends Controller
{
    public function index(){
    	$infofields=InfoField::all();
    	return view('admin-panel.info-fields.index',compact('infofields'));
    }
    public function create(){
    	return view('admin-panel.info-fields.create');
    }
    public function store(Request $request){
    	//dd($request->all());
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('info-fields');
        }
    	$infofield=new InfoField;
    	$infofield->italian_label=$request->get('italian_label');
    	$infofield->english_label=$request->get('english_label');
    	$infofield->field_type=$request->get('field_type');
        $infofield->is_mandatory=$request->get('is_mandatory');
        $infofield->orderNo=$request->get('orderNo');
    	$infofield->field_name=strtolower(str_replace(" ","_",$request->get('english_label')));
    	$fieldType=$request->get('field_type');

    	$nam=str_replace(" ","_",$request->get('english_label'));
    	$nam=strtolower($nam);
        $nam_en=$nam."_en";
        $nam_it=$nam."_it";
    	if(Schema::hasColumn("hotelsinformations",$nam)||Schema::hasColumn("hotelsinformations",$nam_en)||Schema::hasColumn("hotelsinformations",$nam_it)){
    		return redirect('info-fields')->with(['message2'=>'Column already exists']);
    	}
    	if($fieldType=="string"){
    		DB::statement("ALTER TABLE hotelsinformations ADD {$nam_en} VARCHAR(255);");
            DB::statement("ALTER TABLE hotelsinformations ADD {$nam_it} VARCHAR(255);");
    	}
    	if($fieldType=="integer"){
    		DB::statement("ALTER TABLE hotelsinformations ADD {$nam} integer;");
    	}
    	if($fieldType=="date"){
    		DB::statement("ALTER TABLE hotelsinformations ADD {$nam} date;");
    	}
    	if($fieldType=="time"){
    		DB::statement("ALTER TABLE hotelsinformations ADD {$nam} time;");
    	}
    	if($fieldType=="dropdown"){
    		if(empty($request->get('dropdown_items'))){
    			return redirect('info-fields')->with(['message2'=>'Dropdown Items are missing. Try again with adding items if you want to add dropdown field']);
    		}
    		DB::statement("ALTER TABLE hotelsinformations ADD {$nam} VARCHAR(255);");
    		foreach ($request->get('dropdown_items') as $key => $value) {
    			$dropdown=new Dropdown;
    			$dropdown->table_name="hotelsinformations";
    			$dropdown->column_name=$nam;
    			$dropdown->item_name=$value;
    			$dropdown->save();
    		}
    	}
        if($fieldType=="file"){
            DB::statement("ALTER TABLE hotelsinformations ADD {$nam} VARCHAR(255);");
        }
        if($fieldType=="description"){
            DB::statement("ALTER TABLE hotelsinformations ADD {$nam_en} LONGTEXT;");
            DB::statement("ALTER TABLE hotelsinformations ADD {$nam_it} LONGTEXT;");
        }
    	$infofield->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Hotel information field saved successfully']);
        }
    	return redirect('info-fields')->with(['message'=>'Hotel information field saved successfully']);
    }
    public function edit($id){
    	$infofield=InfoField::find($id);
    	return view('admin-panel.info-fields.edit',compact('infofield'));
    }
    public function update(Request $request,$id){
        if($request->get('sav')=="GO BACK WITHOUT SAVING"){
            return redirect('info-fields');
        }
        $infofield=InfoField::find($id);
        $oldtype=$infofield->field_type;
        $old=$infofield->field_name;
        $old_en=$old."_en";
        $old_it=$old."_it";

    	
    	$infofield->italian_label=$request->get('italian_label');
    	$infofield->english_label=$request->get('english_label');
        $infofield->is_mandatory=$request->get('is_mandatory');
        $infofield->orderNo=$request->get('orderNo');

    	if($infofield->field_type!=$request->get('field_type')){

	    	$infofield->field_type=$request->get('field_type');
	    	$infofield->field_name=strtolower(str_replace(" ","_",$request->get('english_label')));
	    	$fieldType=$request->get('field_type');
	    	$nam=str_replace(" ","_",$request->get('english_label'));
	    	$nam=strtolower($nam);
            $nam_en=$nam."_en";
            $nam_it=$nam."_it";
            if(Schema::hasColumn("hotelsinformations",$nam)||Schema::hasColumn("hotelsinformations",$nam_en)||Schema::hasColumn("hotelsinformations",$nam_it)){
                return redirect('info-fields')->with(['message2'=>'Column already exists']);
            }
            if($oldtype=="string"||$oldtype=="description"){
                DB::statement("ALTER TABLE hotelsinformations DROP COLUMN {$old_en}");
                DB::statement("ALTER TABLE hotelsinformations DROP COLUMN {$old_it}");    
            }
            if($oldtype!="string"&&$oldtype!="description"){
                DB::statement("ALTER TABLE hotelsinformations DROP COLUMN {$old}");
            }
	    	if($fieldType=="string"){
	    		DB::statement("ALTER TABLE hotelsinformations ADD {$nam_en} VARCHAR(255);");
                DB::statement("ALTER TABLE hotelsinformations ADD {$nam_it} VARCHAR(255);");
	    	}
            if($fieldType=="description"){
                DB::statement("ALTER TABLE hotelsinformations ADD {$nam_en} LONGTEXT;");
                DB::statement("ALTER TABLE hotelsinformations ADD {$nam_it} LONGTEXT;");
            }
	    	if($fieldType=="integer"){
	    		DB::statement("ALTER TABLE hotelsinformations ADD {$nam} integer;");
	    	}
	    	if($fieldType=="date"){
	    		DB::statement("ALTER TABLE hotelsinformations ADD {$nam} date;");
	    	}
	    	if($fieldType=="time"){
	    		DB::statement("ALTER TABLE hotelsinformations ADD {$nam} time;");
	    	}
	    	if($fieldType=="dropdown"){
                if(empty($request->get('dropdown_items'))){
                    return redirect('info-fields')->with(['message2'=>'Dropdown Items are missing. Try again with adding items if you want to add dropdown field']);
                }
                DB::statement("ALTER TABLE hotelsinformations ADD {$nam} VARCHAR(255);");
                $olds=Dropdown::where('table_name','hotelsinformations')->where('column_name',$name)->get();
                foreach ($olds as $key => $value) {
                    $value->delete();
                }
	    		DB::statement("ALTER TABLE hotelsinformations ADD {$nam} VARCHAR(255);");
	    	}
            if($fieldType=="file"){
                DB::statement("ALTER TABLE hotelsinformations ADD {$nam} VARCHAR(255);");
            }
    	}
    	$infofield->save();
        if($request->get('sav')=="SAVE AND STAY"){
            return redirect()->back()->with(['message'=>'Hotel information field updated successfully']);
        }
    	return redirect('info-fields')->with(['message'=>'Hotel information field updated successfully']);
    }
    public function delete($id){
    	$infofield=InfoField::find($id);
    	$old=$infofield->field_name;
        $old_en=$old."_en";
        $old_it=$old."_it";
        if($infofield->field_type=="string"){
            DB::statement("ALTER TABLE hotelsinformations DROP COLUMN {$old_en}");
            DB::statement("ALTER TABLE hotelsinformations DROP COLUMN {$old_it}");   
        }
        if($infofield->field_type!="string"){
            DB::statement("ALTER TABLE hotelsinformations DROP COLUMN {$old}");
        }
    	DB::statement("ALTER TABLE hotelsinformations DROP COLUMN {$old}");
    	$infofield->delete();
    	
    	return redirect('info-fields')->with(['message'=>'Hotel information field deleted successfully']);
    }
}
