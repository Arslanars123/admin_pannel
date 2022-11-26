<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use App\Models\Reserve;
use App\Models\Booking;
use App\Models\ServiceInfo;
use App\Models\ProductInfo;
use Illuminate\Support\Facades\Auth;
use DB;
use PDF;
use Mail;
class AdminController extends Controller
{
    public function logout(){
        Auth::logout();
        return redirect('login');
    }
    public function index(){
        if(empty(Auth::user())){
            return redirect('login');
        }
        $user=Auth::user();
        if($user->role=="hotel-manager"){
            Auth::login($user);
            return redirect('customer-fields');
        }
        if($user->role=="super-admin"){
            Auth::login($user);
            return redirect('hotels-accounts');
        }
        return redirect('login');
    }
    public function login(Request $request){
    	$exists=User::where('email',$request->get('email'))->where('password',$request->get('password'))->exists();
    	if($exists==false){
    		return redirect('/login')->with(['message2'=>'Email or password is incorrect']);
    	}
        if($exists==true){
            $user=User::where('email',$request->get('email'))->where('password',$request->get('password'))->first();
            if($user->role=="hotel-manager"){
                Auth::login($user);
                return redirect('customer-fields');
            }
            if($user->role=="super-admin"){
                Auth::login($user);
                return redirect('hotels-accounts');
            }
        }
    	
    	
    }
    public function test(){
        DB::statement("ALTER TABLE hotelsinformations ADD logo VARCHAR(255);");
        dd('hi');
        DB::statement("ALTER TABLE hotelsinformations ADD showNameOrImage VARCHAR(255);");
        dd('hi');
        DB::statement("ALTER TABLE users ADD dateTo date;");
        DB::statement("ALTER TABLE users ADD dateFrom date;");
        dd("i");
        $users=User::all();
        foreach($users as $user){
            $user->language="english";
            $user->save();
        }
        dd('hi');
        DB::statement("ALTER TABLE users ADD language VARCHAR(255);");
        dd('hi');
        DB::statement("ALTER TABLE dynamics ADD save_exit text;");
        DB::statement("ALTER TABLE dynamics ADD save_stay text;");
        DB::statement("ALTER TABLE dynamics ADD go_back text;");
        
        DB::statement("ALTER TABLE dynamics ADD products text;");
        DB::statement("ALTER TABLE dynamics ADD services text;");
        DB::statement("ALTER TABLE users ADD reservation_code VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD name VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD email VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD password VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD phone VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD adults VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD children VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD image VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD price VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD createl VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD editl VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD deletel VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD signout VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD title VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD description VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD actions VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD email_templates VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD send_email_hotels VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD send_email_customers VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD labels VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD reserve_service VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD reservations VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD select_service VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD select_customer VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD select_product VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD select_template VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD select_hotel VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD reserve_date VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD event_date VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD number_of_people VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD number_of_children VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD hours_from VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD hours_to VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD addl VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD type VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD customer_name VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD service_name VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD product_name VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD hotel_name VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD order_no VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD dropdown_items VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD total_price VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD print_summary VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD take_pdf VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD creation_date_time VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD stars VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD comment VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD reservation_code text;");
        



        /*DB::statement("ALTER TABLE dynamics ADD products VARCHAR(255);");
        DB::statement("ALTER TABLE dynamics ADD services VARCHAR(255);");
        //DB::statement("ALTER TABLE formats ADD associated_hotel_id VARCHAR(255);");
    	//DB::statement("ALTER TABLE informationfields ADD is_mandatory VARCHAR(255);");
        /*DB::statement("ALTER TABLE informationfields ADD orderNo integer;");

        DB::statement("ALTER TABLE customerfields ADD is_mandatory VARCHAR(255);");
        DB::statement("ALTER TABLE customerfields ADD orderNo integer;");

        DB::statement("ALTER TABLE productfields ADD is_mandatory VARCHAR(255);");
        DB::statement("ALTER TABLE productfields ADD orderNo integer;");

        DB::statement("ALTER TABLE servicefields ADD is_mandatory VARCHAR(255);");
        DB::statement("ALTER TABLE servicefields ADD orderNo integer;");
    	//DB::statement("ALTER TABLE productsinformations ADD images LONGTEXT;");
        */
    	dd('hi');
    }
    public function sendMessage($id,$msg){
        $chat=new Chat;
        $exp=explode("-",$id);
        $chat->customer_id=$exp[1];
        $chat->hotel_id=Auth::user()->associated_hotel_id;
        $chat->message=$msg;
        $chat->read="no";
        $chat->sender="hotel-manager";
        $chat->save();
        return response()->json('Message sent successfully');
    }
    public function updateChat(){
        $chatExists=Chat::where('hotel_id',Auth::user()->associated_hotel_id)->where('read','no')->where('sender','customer')->exists();
        if($chatExists==true){
            $message=Chat::where('hotel_id',Auth::user()->associated_hotel_id)->where('read','no')->where('sender','customer')->first();
            $message->read="yes";
            $message->save();
            return response()->json(['msg'=>$message->message,'update'=>'yes','customer_id'=>$message->customer_id]);
        }
        if($chatExists==false){
            return response()->json(['update'=>'no']);
        }
    }
    public function chat(){
        return view('admin-panel.chats.index');

    }
    public function reservesInCalender($hotel_id){
        return view('admin-panel.calenders.index',compact('hotel_id'));
    }
    public function getEvents($hotel_id){
        $servicesId=array();
        $services=ServiceInfo::where('hotel_id',$hotel_id)->get();
        foreach ($services as $key => $value) {
            array_push($servicesId,$value->id);
        }
        $reserves=Reserve::whereIn('service_id',$servicesId)->get();
        $events=array();
        foreach ($reserves as $key => $value) {
            $customer=User::find($value->user_id);
            $service=ServiceInfo::find($value->service_id);
            $single=array();
            $single['id']=$value->id;
            $single['title']=$customer->name." - ".$service->name_en;
            $single['start']=$value->reserve_date;
            //$single['end']="2022-02-05 20:00:00";
            $single['className']="bg-danger";
            $single['description']="ishq di";

            //$single['reserveDate']="2022-02-02 10:00:00";
            $single['eventDate']=$value->event_date;

            $single['numberOfPeople']=$value->number_of_people;
            $single['numberOfChildren']=$value->number_of_children;

            $single['hoursFrom']=$value->hours_from;
            $single['hoursTo']=$value->hours_to;

            $single['service']=$service->id;
            $single['customer']=$customer->id;
            array_push($events,$single);
        }
        
        return response()->json($events);
    }
    public function submitEvent($reserveDate,$eventDate,$numberOfChildren,$numberOfPeople,$hoursFrom,$hoursTo,$service,$customer){
        $reserve=new Reserve;
        $reserve->reserve_date=$reserveDate;
        $reserve->event_date=$eventDate;
        $reserve->number_of_children=$numberOfChildren;
        $reserve->number_of_people=$numberOfPeople;
        $reserve->hours_from=$hoursFrom;
        $reserve->hours_to=$hoursTo;
        $reserve->service_id=$service;
        $reserve->user_id=$customer;
        $reserve->save();
        return response()->json('added');
    }
    public function forgot(Request $request){
        $exists=User::where('email',$request->get('email'))->exists();
        if($exists==false){
            return redirect('/forgot')->with(['message2'=>'Email is incorrect']);
        }
        if($exists==true){
            $user=User::where('email',$request->get('email'))->first();
            $email=$user->email;
            Mail::send('mailf',['user'=>$user], function($message) use($email){
                 $message->to($email)->subject('Geokge');
                 $message->from('pagoda.app@gmail.com');
                
                });
            return redirect('sentmessage')->with("message","L'email per reimpostare la password è stata inviata.");
        }
    }
    public function getSummary($id){
        $bookings=Booking::where('user_id',$id)->get();
        $reserves=Reserve::where('user_id',$id)->get();
        $totalPrice=0;
        foreach ($bookings as $key => $value) {
            $product=ProductInfo::find($value->product_id);
            $totalPrice=$totalPrice+$product->price;
        }
        foreach ($reserves as $key => $value) {
            $service=ServiceInfo::find($value->service_id);
            $totalPrice=$totalPrice+$service->price;
        }
        $user=User::find($id);
        return view('admin-panel.customers.popup',compact('bookings','reserves','totalPrice','user'));
    }
    public function getPdf($id){
        $bookings=Booking::where('user_id',$id)->get();
        $reserves=Reserve::where('user_id',$id)->get();
        $totalPrice=0;
        foreach ($bookings as $key => $value) {
            $totalPrice=$totalPrice+$value->price;
        }
        foreach ($reserves as $key => $value) {
            $totalPrice=$totalPrice+$value->price;
        }
        $user=User::find($id);
         $data = [
            'bookings' => $bookings,
            'reserves' => $reserves,
            'totalPrice' => $totalPrice,
            'user' => $user
        ];
          
        $pdf = PDF::loadView('admin-panel.customers.popup', $data);
    
        return $pdf->download('summary.pdf');
        //return view('admin-panel.customers.popup',compact('bookings','reserves','totalPrice','user'));
    }
    public function forgotLink($id){
        $user=User::find($id);
        return view('change',compact('user'));
    }
    public function change(Request $request){
        if($request->get('password')!=$request->get('passwordc')){
            return redirect()->back()->with('message2','Password e conferma password non corrispondono');
        }
        $user=User::find($request->get('userId'));
        $user->password=$request->get('password');
        $user->save();
        return redirect('login')->with('message','Password cambiata con successo');
    }
    public function changeMyPassword(){
        $user=User::find(Auth::user()->id);
        return view('change',compact('user'));
    }

}
