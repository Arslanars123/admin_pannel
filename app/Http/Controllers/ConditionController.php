<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Condition;
class ConditionController extends Controller
{
    public function index($hotel_id){
		$exists=Condition::where('hotel_id',$hotel_id)->exists();
		if($exists==true){
			$condition= Condition::where('hotel_id',$hotel_id)->first();
			return view('admin-panel.conditions.edit',compact('condition'));
		}
		$condition=new Condition;
		$condition->hotel_id=$hotel_id;
		$condition->save();
		return view('admin-panel.conditions.edit',compact('condition'));
	}
    public function update(Request $request,$id){
    	$condition=Condition::find($id);
    	$condition->termsandconditions=$request->get('termsandconditions');
    	$condition->save();
    	return redirect('conditions/'.$condition->hotel_id);

    }
}
