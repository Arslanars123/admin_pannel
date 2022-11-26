<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dynamic;
use Input;
class DynamicController extends Controller
{
	public function index(){
		$exists=Dynamic::exists();
		if($exists==true){
			$dynamic= Dynamic::first();
			return view('admin-panel.dynamics.edit',compact('dynamic'));
		}
		$dynamic=new Dynamic;
		$dynamic->save();
		return view('admin-panel.dynamics.edit',compact('dynamic'));
	}
    public function update(Request $request){
    	$dynamic=Dynamic::first();
    	$image=Input::file("main_logo");
        if(!empty($image)){
            $newFilename=$image->getClientOriginalName();
            $destinationPath='dynamicsImages';
            $image->move($destinationPath,$newFilename);
            $picPath='dynamicsImages/' . $newFilename;
            $dynamic->main_logo=$picPath;
        }

    	$dynamic->main_logo_title=$request->get('main_logo_title');
    	$dynamic->hotels_accounts=$request->get('hotels_accounts');
    	$dynamic->hotels_info_fields=$request->get('hotels_info_fields');
    	$dynamic->customers_fields=$request->get('customers_fields');
    	$dynamic->products_fields=$request->get('products_fields');
    	$dynamic->services_fields=$request->get('services_fields');
    	$dynamic->customers=$request->get('customers');
        $dynamic->products=$request->get('products');
        $dynamic->services=$request->get('services');
    	$dynamic->categories=$request->get('categories');
    	$dynamic->hotel_information=$request->get('hotel_information');
    	$dynamic->ratings=$request->get('ratings');
    	$dynamic->chat=$request->get('chat');
    	$dynamic->services_reservations_calender=$request->get('services_reservations_calender');
    	$dynamic->bookings=$request->get('bookings');
    	$dynamic->services_reservations=$request->get('services_reservations');
    	$dynamic->english_label=$request->get('english_label');
    	$dynamic->italian_label=$request->get('italian_label');
    	$dynamic->is_mandatory=$request->get('is_mandatory');
    	$dynamic->field_type=$request->get('field_type');
    	$dynamic->summary=$request->get('summary');
    	$dynamic->copyright=$request->get('copyright');

        $dynamic->name=$request->get('name');
        $dynamic->email=$request->get('email');
        $dynamic->password=$request->get('password');
        $dynamic->phone=$request->get('phone');
        $dynamic->adults=$request->get('adults');
        $dynamic->children=$request->get('children');
        $dynamic->image=$request->get('image');
        $dynamic->price=$request->get('price');
        $dynamic->createl=$request->get('createl');
        $dynamic->editl=$request->get('editl');
        $dynamic->deletel=$request->get('deletel');
        $dynamic->signout=$request->get('signout');
        $dynamic->title=$request->get('title');
        $dynamic->description=$request->get('description');
        $dynamic->actions=$request->get('actions');
        $dynamic->email_templates=$request->get('email_templates');
        $dynamic->send_email_hotels=$request->get('send_email_hotels');
        $dynamic->send_email_customers=$request->get('send_email_customers');
        $dynamic->labels=$request->get('labels');
        $dynamic->reserve_service=$request->get('reserve_service');
        $dynamic->reservations=$request->get('reservations');
        $dynamic->select_service=$request->get('select_service');
        $dynamic->select_customer=$request->get('select_customer');
        $dynamic->select_product=$request->get('select_product');
        $dynamic->select_template=$request->get('select_template');
        $dynamic->select_hotel=$request->get('select_hotel');
        $dynamic->reserve_date=$request->get('reserve_date');
        $dynamic->event_date=$request->get('event_date');
        $dynamic->number_of_people=$request->get('number_of_people');

        $dynamic->number_of_children=$request->get('number_of_children');
        $dynamic->hours_from=$request->get('hours_from');
        $dynamic->hours_to=$request->get('hours_to');
        $dynamic->addl=$request->get('addl');
        $dynamic->type=$request->get('type');
        $dynamic->customer_name=$request->get('customer_name');
        $dynamic->service_name=$request->get('service_name');
        $dynamic->product_name=$request->get('product_name');
        $dynamic->hotel_name=$request->get('hotel_name');
        $dynamic->order_no=$request->get('order_no');
        $dynamic->dropdown_items=$request->get('dropdown_items');
        $dynamic->total_price=$request->get('total_price');
        $dynamic->print_summary=$request->get('print_summary');
        $dynamic->take_pdf=$request->get('take_pdf');

        $dynamic->creation_date_time=$request->get('creation_date_time');
        $dynamic->stars=$request->get('stars');
        $dynamic->comment=$request->get('comment');
        $dynamic->reservation_code=$request->get('reservation_code');

        $dynamic->save_exit=$request->get('save_exit');
        $dynamic->save_stay=$request->get('save_stay');
        $dynamic->go_back=$request->get('go_back');
    	$dynamic->save();
    	return redirect('dynamics');

    }
}
