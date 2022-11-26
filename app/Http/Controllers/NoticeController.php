<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;
class NoticeController extends Controller
{
    public function index(){
		$exists=Notice::exists();
		if($exists==true){
			$notice= Notice::first();
			return view('admin-panel.notices.edit',compact('notice'));
		}
		$notice=new Notice;
		$notice->save();
		return view('admin-panel.notices.edit',compact('notice'));
	}
    public function update(Request $request,$id){
    	$notice=Notice::first();
    	$notice->notice=$request->get('notice');
    	$notice->save();
    	return redirect('notices');

    }
}
