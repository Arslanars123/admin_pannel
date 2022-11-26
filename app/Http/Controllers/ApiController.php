<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HotelInfo;
use App\Models\ProductInfo;
use App\Models\ServiceInfo;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Booking;
use App\Models\Reserve;
use App\Models\Rating;
use App\Models\User;
use App\Models\Account;
use App\Models\InfoField;
use App\Models\ProductField;
use App\Models\ServiceField;
use App\Models\CustomerField;
use Mail;
use App\Models\Condition;
use App\Models\Notice;
class ApiController extends Controller
{
    public function getTermsConditions(Request $request){
        if(empty($request->json('hotel_id'))){
            return response()->json(['status'=>401,'message'=>'hotel id is missing']);
        }
        $conditions=Condition::where('hotel_id',$request->json('hotel_id'))->first();
        return response()->json(['status'=>200,'data'=>$conditions]);
    }
    public function getNotice(Request $request){
        $notice=Notice::first();
        return response()->json(['status'=>200,'data'=>$notice]);
    }
    public function setLanguage(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        if(empty($request->json('language'))){
            return response()->json(['status'=>401,'message'=>'language is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $user=User::find($request->json('user_id'));
        $user->language=$request->json('language');
        $user->save();
        if(!empty($user->reservation_code)){
            $hotel=Account::find($user->associated_hotel_id);
            $info=HotelInfo::where('hotel_id',$hotel->id)->first();
            $hotel->setAttribute('image',$info->image);
            $customerInfoArray=array();
            $userFields=CustomerField::orderBy('orderNo','asc')->get();
            foreach ($userFields as $key => $unf) {
                if(!empty($user[''.$unf->field_name])){
                    //$single['label']=$inf->english_label;
                    $single['label']=$unf->italian_label;
                    if($unf->field_type=="string"||$unf->field_type=="description"){
                        //$single['value']=$info[''.$unf->field_name."_en"];
                        $single['value_it']=$user[''.$unf->field_name."_it"];
                    }
                    if($unf->field_type!="string"&&$unf->field_type!="description"){
                        $single['value']=$user[''.$unf->field_name];
                    }
                    
                    $single['type']=$unf->field_type;
                    array_push($customerInfoArray,$single);
                }
            }
            $user->setAttribute('customerInfo',$customerInfoArray);
            $infoArray=array();
            if(!empty($info)){
                
                $infoFields=InfoField::orderBy('orderNo','asc')->get();
                foreach ($infoFields as $key => $inf) {
                    if(!empty($info[''.$inf->field_name])){
                        if($user->language=="english"){
                            $single['label']=$inf->english_label;
                        }
                        if($user->language=="italian"){
                            $single['label']=$inf->italian_label;
                        }
                        if($inf->field_type=="string"||$inf->field_type=="description"){
                            if($user->language=="english"){
                                $single['value']=$info[''.$inf->field_name."_en"];
                            }
                            if($user->language=="italian"){
                                $single['value']=$info[''.$inf->field_name."_it"];
                            }
                        }
                        if($inf->field_type!="string"&&$inf->field_type!="description"){
                            $single['value']=$info[''.$inf->field_name];
                        }
                        
                        $single['type']=$inf->field_type;
                        array_push($infoArray,$single);
                    }
                }
                $hotel->setAttribute('info',$infoArray);
            }
            if(empty($info)){
                $hotel->setAttribute('info',$infoArray);
            }

            //product categories
            $productCategories=Category::where('type','product')->where('hotel_id',$hotel->id)->get();
            $pca=array();
            if(!empty($productCategories)){
                foreach ($productCategories as $key => $pc) {
                    $singlec=array();
                    $singlec['id']=$pc->id;
                    if($user->language=="english"){
                        $singlec['name']=$pc->name_en;
                    }
                    if($user->language=="italian"){
                        $singlec['name']=$pc->name_it;
                    }
                    
                    $singlec['image']=$pc->image;
                    $productsArray=array();
                    $products=ProductInfo::where('category_id',$pc->id)->get();
                    if(!empty($products)){
                        foreach ($products as $key => $p) {
                            $singlep['id']=$p->id;
                            if($user->language=="english"){
                                $singlep['name']=$p->name_en;
                            }
                            if($user->language=="italian"){
                                $singlep['name']=$p->name_it;
                            }
                            
                            $singlep['image']=$p->image;
                            $singlep['price']=$p->price;
                            $singlep['images']=$p->images;

                            $productDynamicArray=array();
                            $productFields=ProductField::orderBy('orderNo','asc')->get();
                            foreach ($productFields as $key => $pf) {
                                if(!empty($p[''.$pf->field_name])){
                                    if($user->language=="english"){
                                        $singlepf['label']=$pf->english_label;
                                    }
                                    if($user->language=="italian"){
                                        $singlepf['label']=$pf->italian_label;
                                    }
                                    if($pf->field_type=="string"||$pf->field_type=="description"){
                                        if($user->language=="english"){
                                            $singlepf['value_it']=$p[''.$pf->field_name."_en"];
                                        }
                                        if($user->language=="italian"){
                                            $singlepf['value_it']=$p[''.$pf->field_name."_it"];
                                        }
                                    }
                                    if($pf->field_type!="string"&&$pf->field_type!="description"){
                                        $singlepf['value']=$p[''.$pf->field_name];
                                    }
                                    
                                    $singlepf['type']=$pf->field_type;
                                    array_push($productDynamicArray,$singlepf);
                                }
                            }
                            $singlep['dynamic']=$productDynamicArray;
                            array_push($productsArray,$singlep);
                        }
                    }
                    $singlec['products']=$productsArray;
                    array_push($pca,$singlec);
                }
                $hotel->setAttribute('product_categories',$pca);
            }
            if(empty($productCategories)){
                $hotel->setAttribute('product_categories',$pca);
            }

            //service categories
            $serviceCategories=Category::where('type','service')->where('hotel_id',$hotel->id)->get();
            $sca=array();
            if(!empty($serviceCategories)){
                foreach ($serviceCategories as $key => $sc) {
                    $singlec=array();
                    $singlec['id']=$sc->id;
                    if($user->language=="english"){
                        $singlec['name']=$sc->name_en;
                    }
                    if($user->language=="italian"){
                        $singlec['name']=$sc->name_it;
                    }
                    $singlec['image']=$sc->image;
                    $servicesArray=array();
                    $services=ServiceInfo::where('category_id',$sc->id)->get();
                    if(!empty($services)){
                        foreach ($services as $key => $s) {
                            $singles['id']=$s->id;
                            if($user->language=="english"){
                                $singles['name']=$s->name_en;
                            }
                            if($user->language=="italian"){
                                $singles['name']=$s->name_it;
                            }
                            $singles['image']=$s->image;
                            $singles['price']=$s->price;
                            $singles['images']=$s->images;

                            $serviceDynamicArray=array();
                            $serviceFields=ServiceField::orderBy('orderNo','asc')->get();
                            foreach ($serviceFields as $key => $sf) {
                                if(!empty($s[''.$sf->field_name])){
                                    if($user->language=="english"){
                                        $singlesf['label']=$sf->english_label;
                                    }
                                    if($user->language=="italian"){
                                        $singlesf['label']=$sf->italian_label;
                                    }
                                    if($sf->field_type=="string"||$sf->field_type=="description"){
                                        //$single['value']=$info[''.$inf->field_name."_en"];
                                        if($user->language=="english"){
                                            $singlesf['value_it']=$s[''.$sf->field_name."_en"];
                                        }
                                        if($user->language=="italian"){
                                            $singlesf['value_it']=$s[''.$sf->field_name."_it"];
                                        }
                                        
                                    }
                                    if($sf->field_type!="string"&&$sf->field_type!="description"){
                                        $singlesf['value']=$s[''.$sf->field_name];
                                    }
                                    
                                    $singlesf['type']=$sf->field_type;
                                    array_push($serviceDynamicArray,$singlesf);
                                }
                            }
                            $singles['dynamic']=$serviceDynamicArray;
                            array_push($servicesArray,$singles);
                        }
                    }
                    $singlec['services']=$servicesArray;
                    array_push($sca,$singlec);
                }
                $hotel->setAttribute('service_categories',$sca);
            }
            if(empty($serviceCategories)){
                $hotel->setAttribute('service_categories',$sca);
            }
            $reviewsArray=array();
            $ratingsExists=Rating::where('hotel_id',$hotel->id)->exists();
            if($ratingsExists==true){
                $ratingsCount=Rating::where('hotel_id',$hotel->id)->count();
                $hotel->setAttribute('number_of_reviews',$ratingsCount);
                $ratings=Rating::where('hotel_id',$hotel->id)->get();
                $starsSum=0;
                
                foreach($ratings as $rating){
                    $usr=User::find($rating->user_id);
                    if(!empty($usr)){
                        $single=array();
                        $single['user_name']=$usr->name;
                        $single['user_image']=$usr->image;
                        $single['stars']=$rating->stars;
                        $single['comment']=$rating->comment;
                        array_push($reviewsArray,$single);
                        $starsSum=$starsSum+$rating->stars;
                    }
                }
                $starsAverage=$starsSum/$ratingsCount;
                $starsAverage=number_format($starsAverage,1);
                $hotel->setAttribute('average_rating',$starsAverage);
                $hotel->setAttribute('reviews_array',$reviewsArray);
            }
            if($ratingsExists==false){
                $hotel->setAttribute('number_of_reviews',0);
                $hotel->setAttribute('average_rating',0);
                $hotel->setAttribute('reviews_array',$reviewsArray);
            }
            return response()->json(['status'=>200,'data2'=>$user,'data'=>$hotel]);
        }
        return response()->json(['status'=>200,'data'=>$user]);
    }
    public function bookedProducts(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $user=User::find($request->json('user_id'));
        $bookings=Booking::where('user_id',$user->id)->get();
        return response()->json(['status'=>200,'data'=>$bookings]);
    }
    public function reservedServices(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $user=User::find($request->json('user_id'));
        $reservesArray=array();
        $datesR=Reserve::where('user_id',$user->id)->select('reserve_date')->distinct()->get();
        foreach($datesR as $dR){
            $single=array();
            $single['reserve_date']=$dR->reserve_date;
            $reserves=Reserve::where('user_id',$user->id)->where('reserve_date',$dR->reserve_date)->get();
            foreach($reserves as $re){
                $ser=ServiceInfo::find($re->service_id);
                $re->setAttribute('service',$ser);
            }
            $single['reserves']=$reserves;
            array_push($reservesArray,$single);
        }
        return response()->json(['status'=>200,'data'=>$reservesArray]);
    }
    public function checkCode(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $userI=User::find($request->json('user_id'));
        if(empty($request->json('reservation_code'))){
            return response()->json(['status'=>401,'message'=>'Some field is missing. All fields are required']);      
        }
        $userExists=User::where('reservation_code',$request->json('reservation_code'))->exists();
        if($userExists==false){
            return response()->json(['status'=>200,'message'=>'No user belong to this code']);
        }
        $user=User::where('reservation_code',$request->json('reservation_code'))->first();
        if($user->id!=$userI->id){
            return response()->json(['status'=>401,'message'=>'Reservation code does not belong to this user']);
        }
        $hotel=Account::find($user->associated_hotel_id);
        $info=HotelInfo::where('hotel_id',$hotel->id)->first();
        $hotel->setAttribute('image',$info->image);
        $hotel->setAttribute('logo',$info->logo);
        $hotel->setAttribute('show',$info->showNameOrImage);
        $conditionsE=Condition::where('hotel_id',$hotel->id)->exists();
        if(!empty($conditionsE)){
            $conditions=Condition::where('hotel_id',$hotel->id)->first();
            $hotel->setAttribute('terms_conditions',$conditions);
        }
        if(empty($conditionsE)){
            $hotel->setAttribute('terms_conditions',null);
        }
        $customerInfoArray=array();
        $userFields=CustomerField::orderBy('orderNo','asc')->get();
        foreach ($userFields as $key => $unf) {
            if(!empty($user[''.$unf->field_name])){
                //$single['label']=$inf->english_label;
                $single['label']=$unf->italian_label;
                if($unf->field_type=="string"||$unf->field_type=="description"){
                    //$single['value']=$info[''.$unf->field_name."_en"];
                    $single['value_it']=$user[''.$unf->field_name."_it"];
                }
                if($unf->field_type!="string"&&$unf->field_type!="description"){
                    $single['value']=$user[''.$unf->field_name];
                }
                
                $single['type']=$unf->field_type;
                array_push($customerInfoArray,$single);
            }
        }
        $user->setAttribute('customerInfo',$customerInfoArray);
        $infoArray=array();
        if(!empty($info)){
            
            $infoFields=InfoField::orderBy('orderNo','asc')->get();
            foreach ($infoFields as $key => $inf) {
                if(!empty($info[''.$inf->field_name])){
                    if($user->language=="english"){
                        $single['label']=$inf->english_label;
                    }
                    if($user->language=="italian"){
                        $single['label']=$inf->italian_label;
                    }
                    if($inf->field_type=="string"||$inf->field_type=="description"){
                        if($user->language=="english"){
                            $single['value']=$info[''.$inf->field_name."_en"];
                        }
                        if($user->language=="italian"){
                            $single['value']=$info[''.$inf->field_name."_it"];
                        }
                    }
                    if($inf->field_type!="string"&&$inf->field_type!="description"){
                        $single['value']=$info[''.$inf->field_name];
                    }
                    
                    $single['type']=$inf->field_type;
                    array_push($infoArray,$single);
                }
            }
            $hotel->setAttribute('info',$infoArray);
        }
        if(empty($info)){
            $hotel->setAttribute('info',$infoArray);
        }

        //product categories
        $productCategories=Category::where('type','product')->where('hotel_id',$hotel->id)->get();
        $pca=array();
        if(!empty($productCategories)){
            foreach ($productCategories as $key => $pc) {
                $singlec=array();
                $singlec['id']=$pc->id;
                if($user->language=="english"){
                    $singlec['name']=$pc->name_en;
                }
                if($user->language=="italian"){
                    $singlec['name']=$pc->name_it;
                }
                
                $singlec['image']=$pc->image;
                $productsArray=array();
                $products=ProductInfo::where('category_id',$pc->id)->get();
                if(!empty($products)){
                    foreach ($products as $key => $p) {
                        $singlep['id']=$p->id;
                        if($user->language=="english"){
                            $singlep['name']=$p->name_en;
                        }
                        if($user->language=="italian"){
                            $singlep['name']=$p->name_it;
                        }
                        
                        $singlep['image']=$p->image;
                        $singlep['price']=$p->price;
                        $singlep['images']=$p->images;

                        $productDynamicArray=array();
                        $productFields=ProductField::orderBy('orderNo','asc')->get();
                        foreach ($productFields as $key => $pf) {
                            if(!empty($p[''.$pf->field_name])){
                                if($user->language=="english"){
                                    $singlepf['label']=$pf->english_label;
                                }
                                if($user->language=="italian"){
                                    $singlepf['label']=$pf->italian_label;
                                }
                                if($pf->field_type=="string"||$pf->field_type=="description"){
                                    if($user->language=="english"){
                                        $singlepf['value_it']=$p[''.$pf->field_name."_en"];
                                    }
                                    if($user->language=="italian"){
                                        $singlepf['value_it']=$p[''.$pf->field_name."_it"];
                                    }
                                }
                                if($pf->field_type!="string"&&$pf->field_type!="description"){
                                    $singlepf['value']=$p[''.$pf->field_name];
                                }
                                
                                $singlepf['type']=$pf->field_type;
                                array_push($productDynamicArray,$singlepf);
                            }
                        }
                        $singlep['dynamic']=$productDynamicArray;
                        array_push($productsArray,$singlep);
                    }
                }
                $singlec['products']=$productsArray;
                array_push($pca,$singlec);
            }
            $hotel->setAttribute('product_categories',$pca);
        }
        if(empty($productCategories)){
            $hotel->setAttribute('product_categories',$pca);
        }

        //service categories
        $serviceCategories=Category::where('type','service')->where('hotel_id',$hotel->id)->get();
        $sca=array();
        if(!empty($serviceCategories)){
            foreach ($serviceCategories as $key => $sc) {
                $singlec=array();
                $singlec['id']=$sc->id;
                if($user->language=="english"){
                    $singlec['name']=$sc->name_en;
                }
                if($user->language=="italian"){
                    $singlec['name']=$sc->name_it;
                }
                $singlec['image']=$sc->image;
                $servicesArray=array();
                $services=ServiceInfo::where('category_id',$sc->id)->get();
                if(!empty($services)){
                    foreach ($services as $key => $s) {
                        $singles['id']=$s->id;
                        if($user->language=="english"){
                            $singles['name']=$s->name_en;
                        }
                        if($user->language=="italian"){
                            $singles['name']=$s->name_it;
                        }
                        $singles['image']=$s->image;
                        $singles['price']=$s->price;
                        $singles['images']=$s->images;

                        $serviceDynamicArray=array();
                        $serviceFields=ServiceField::orderBy('orderNo','asc')->get();
                        foreach ($serviceFields as $key => $sf) {
                            if(!empty($s[''.$sf->field_name])){
                                if($user->language=="english"){
                                    $singlesf['label']=$sf->english_label;
                                }
                                if($user->language=="italian"){
                                    $singlesf['label']=$sf->italian_label;
                                }
                                if($sf->field_type=="string"||$sf->field_type=="description"){
                                    //$single['value']=$info[''.$inf->field_name."_en"];
                                    if($user->language=="english"){
                                        $singlesf['value_it']=$s[''.$sf->field_name."_en"];
                                    }
                                    if($user->language=="italian"){
                                        $singlesf['value_it']=$s[''.$sf->field_name."_it"];
                                    }
                                    
                                }
                                if($sf->field_type!="string"&&$sf->field_type!="description"){
                                    $singlesf['value']=$s[''.$sf->field_name];
                                }
                                
                                $singlesf['type']=$sf->field_type;
                                array_push($serviceDynamicArray,$singlesf);
                            }
                        }
                        $singles['dynamic']=$serviceDynamicArray;
                        array_push($servicesArray,$singles);
                    }
                }
                $singlec['services']=$servicesArray;
                array_push($sca,$singlec);
            }
            $hotel->setAttribute('service_categories',$sca);
        }
        if(empty($serviceCategories)){
            $hotel->setAttribute('service_categories',$sca);
        }
        $reviewsArray=array();
        $ratingsExists=Rating::where('hotel_id',$hotel->id)->exists();
        if($ratingsExists==true){
            $ratingsCount=Rating::where('hotel_id',$hotel->id)->count();
            $hotel->setAttribute('number_of_reviews',$ratingsCount);
            $ratings=Rating::where('hotel_id',$hotel->id)->get();
            $starsSum=0;
            
            foreach($ratings as $rating){
                $usr=User::find($rating->user_id);
                if(!empty($usr)){
                    $single=array();
                    $single['user_name']=$usr->name;
                    $single['user_image']=$usr->image;
                    $single['stars']=$rating->stars;
                    $single['comment']=$rating->comment;
                    array_push($reviewsArray,$single);
                    $starsSum=$starsSum+$rating->stars;
                }
            }
            $starsAverage=$starsSum/$ratingsCount;
            $starsAverage=number_format($starsAverage,1);
            $hotel->setAttribute('average_rating',$starsAverage);
            $hotel->setAttribute('reviews_array',$reviewsArray);
        }
        if($ratingsExists==false){
            $hotel->setAttribute('number_of_reviews',0);
            $hotel->setAttribute('average_rating',0);
            $hotel->setAttribute('reviews_array',$reviewsArray);
        }
        return response()->json(['status'=>200,'data'=>$hotel,'data2'=>$user]);
    
    }
    public function facebookGoogle(Request $request){
        if(empty($request->json('name'))||empty($request->json('email'))){
            return response()->json(['status'=>401,'message'=>'Some field is missing. All fields are required']);
        }
        $emailExists=User::where('email',$request->json('email'))->exists();
        if($emailExists==true){
            $user=User::where('email',$request->json('email'))->first();
            return response()->json(['status'=>200,'message'=>'Logged in successfully','data'=>$user]);
        }
        $user=new User;
        $user->name=$request->json('name');
        $user->email=$request->json('email');
        $user->role="app-user";
        $user->save();
        return response()->json(['status'=>200,'message'=>'Registered successfully','data'=>$user]);

    }
    public function register(Request $request){
        if(empty($request->json('name'))||empty($request->json('email'))||empty($request->json('password'))||empty($request->json('phone'))){
            return response()->json(['status'=>401,'message'=>'Some field is missing. All fields are required']);
        }
        $emailExists=User::where('email',$request->json('email'))->exists();
        if($emailExists==true){
            return response()->json(['status'=>401,'message'=>'Email already exists']);
        }
        $user=new User;
        $user->name=$request->json('name');
        $user->email=$request->json('email');
        $user->password=$request->json('password');
        $user->phone=$request->json('phone');
        $user->role="app-user";
        $user->save();
        return response()->json(['status'=>200,'message'=>'Registered successfully','data'=>$user]);

    }
    public function login(Request $request){
        if(empty($request->json('email'))||empty($request->json('password'))){
            return response()->json(['status'=>401,'message'=>'Some field is missing. All fields are required']);
        }
        $roles=["customer","app-user"];
        $userExists=User::where('email',$request->json('email'))->where('password',$request->json('password'))->whereIn('role',$roles)->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'Email or password is incorrect']);
        }
        $user=User::where('email',$request->json('email'))->where('password',$request->json('password'))->whereIn('role',$roles)->first();
        return response()->json(['status'=>200,'message'=>'Logged in successfully','data'=>$user]);

    }
    public function bookProduct(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        if(empty($request->json('product_id'))){
            return response()->json(['status'=>401,'message'=>'product id is missing']);
        }
        $productExists=ProductInfo::where('id',$request->json('product_id'))->exists();
        if($productExists==false){
            return response()->json(['status'=>401,'message'=>'Product does not exists']); 
        }
        $booking=new Booking;
        $booking->user_id=$request->json('user_id');
        $booking->product_id=$request->json('product_id');
        $booking->save();
        return response()->json(['status'=>200,'message'=>'Product booked successfully']);
    }
    public function reserveService(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        if(empty($request->json('service_id'))){
            return response()->json(['status'=>401,'message'=>'service id is missing']);
        }
        $serviceExists=ServiceInfo::where('id',$request->json('service_id'))->exists();
        if($serviceExists==false){
            return response()->json(['status'=>401,'message'=>'Service does not exists']); 
        }
        $reserve=new Reserve;
        $reserve->user_id=$request->json('user_id');
        $reserve->reserve_date=$request->json('reserve_date');
        $reserve->event_date=$request->json('event_date');
        $reserve->number_of_people=$request->json('number_of_people');
        $reserve->number_of_children=$request->json('number_of_children');
        $reserve->hours_from=$request->json('hours_from');
        $reserve->hours_to=$request->json('hours_to');
        $reserve->detail=$request->json('detail');
        $reserve->service_id=$request->json('service_id');
        $reserve->save();
        return response()->json(['status'=>200,'message'=>'Service reserved successfully']);
    }
    public function rateHotel(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        if(empty($request->json('hotel_id'))){
            return response()->json(['status'=>401,'message'=>'hotel id is missing']);
        }
        $hotelExists=HotelInfo::where('id',$request->json('hotel_id'))->exists();
        if($hotelExists==false){
            return response()->json(['status'=>401,'message'=>'Hotel does not exists']);    
        }
        $rating=new Rating;
        $rating->stars=$request->json('stars');
        $rating->comment=$request->json('comment');
        $rating->hotel_id=$request->json('hotel_id');
        $rating->user_id=$request->json('user_id');
        $rating->save();
        return response()->json(['status'=>200,'message'=>'Rated successfully']);
    }

    public function sendMessage(Request $request){
        $chat=new Chat;
        $chat->customer_id=$request->json('customer_id');
        $chat->hotel_id=$request->json('hotel_id');
        $chat->message=$request->json('message');
        $chat->read="no";
        $chat->sender="customer";
        $chat->save();
        $chats=Chat::where('hotel_id',$request->json('hotel_id'))
        ->where('customer_id',$request->json('customer_id'))->get();
        //return response()->json(['status'=>200,'data'=>$chats]);
        return response()->json(['status'=>200,'message'=>'Message sent successfully','data'=>$chats]);
    }
    public function getHistory(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        if(empty($request->json('hotel_id'))){
            return response()->json(['status'=>401,'message'=>'hotel id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $chats=Chat::where('customer_id',$request->json('user_id'))->where('hotel_id',$request->json('hotel_id'))->get();
        
        return response()->json(['status'=>200,'data'=>$chats]);
                
    }
    public function getHotels(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $user=User::find($request->json('user_id'));
        $hotels= Account::all();
        
        foreach($hotels as $hotel){

            $info=HotelInfo::where('hotel_id',$hotel->id)->first();
            $hotel->setAttribute('image',$info->image);
            $hotel->setAttribute('logo',$info->logo);
            $hotel->setAttribute('show',$info->showNameOrImage);
            $conditionsE=Condition::where('hotel_id',$hotel->id)->exists();
            if(!empty($conditionsE)){
                $conditions=Condition::where('hotel_id',$hotel->id)->first();
                $hotel->setAttribute('terms_conditions',$conditions);
            }
            if(empty($conditionsE)){
                $hotel->setAttribute('terms_conditions',null);
            }
            
            $infoArray=array();
            if(!empty($info)){
                
                $infoFields=InfoField::orderBy('orderNo','asc')->get();
                foreach ($infoFields as $key => $inf) {
                    if(!empty($info[''.$inf->field_name])){
                        if($user->language=="english"){
                            $single['label']=$inf->english_label;
                        }
                        if($user->language=="italian"){
                            $single['label']=$inf->italian_label;
                        }
                        if($inf->field_type=="string"||$inf->field_type=="description"){
                            if($user->language=="english"){
                                $single['value']=$info[''.$inf->field_name."_en"];
                            }
                            if($user->language=="italian"){
                                $single['value']=$info[''.$inf->field_name."_it"];
                            }
                        }
                        if($inf->field_type!="string"&&$inf->field_type!="description"){
                            $single['value']=$info[''.$inf->field_name];
                        }
                        
                        $single['type']=$inf->field_type;
                        array_push($infoArray,$single);
                    }
                }
                $hotel->setAttribute('info',$infoArray);
            }
            if(empty($info)){
                $hotel->setAttribute('info',$infoArray);
            }

            //product categories
            $productCategories=Category::where('type','product')->where('hotel_id',$hotel->id)->get();
            $pca=array();
            if(!empty($productCategories)){
                foreach ($productCategories as $key => $pc) {
                    $singlec=array();
                    $singlec['id']=$pc->id;
                    if($user->language=="english"){
                        $singlec['name']=$pc->name_en;
                    }
                    if($user->language=="italian"){
                        $singlec['name']=$pc->name_it;
                    }
                    
                    $singlec['image']=$pc->image;
                    $productsArray=array();
                    $products=ProductInfo::where('category_id',$pc->id)->get();
                    if(!empty($products)){
                        foreach ($products as $key => $p) {
                            $singlep['id']=$p->id;
                            if($user->language=="english"){
                                $singlep['name']=$p->name_en;
                            }
                            if($user->language=="italian"){
                                $singlep['name']=$p->name_it;
                            }
                            
                            $singlep['image']=$p->image;
                            $singlep['price']=$p->price;
                            $singlep['images']=$p->images;

                            $productDynamicArray=array();
                            $productFields=ProductField::orderBy('orderNo','asc')->get();
                            foreach ($productFields as $key => $pf) {
                                if(!empty($p[''.$pf->field_name])){
                                    if($user->language=="english"){
                                        $singlepf['label']=$pf->english_label;
                                    }
                                    if($user->language=="italian"){
                                        $singlepf['label']=$pf->italian_label;
                                    }
                                    if($pf->field_type=="string"||$pf->field_type=="description"){
                                        if($user->language=="english"){
                                            $singlepf['value_it']=$p[''.$pf->field_name."_en"];
                                        }
                                        if($user->language=="italian"){
                                            $singlepf['value_it']=$p[''.$pf->field_name."_it"];
                                        }
                                    }
                                    if($pf->field_type!="string"&&$pf->field_type!="description"){
                                        $singlepf['value']=$p[''.$pf->field_name];
                                    }
                                    
                                    $singlepf['type']=$pf->field_type;
                                    array_push($productDynamicArray,$singlepf);
                                }
                            }
                            $singlep['dynamic']=$productDynamicArray;
                            array_push($productsArray,$singlep);
                        }
                    }
                    $singlec['products']=$productsArray;
                    array_push($pca,$singlec);
                }
                $hotel->setAttribute('product_categories',$pca);
            }
            if(empty($productCategories)){
                $hotel->setAttribute('product_categories',$pca);
            }

            //service categories
            $serviceCategories=Category::where('type','service')->where('hotel_id',$hotel->id)->get();
            $sca=array();
            if(!empty($serviceCategories)){
                foreach ($serviceCategories as $key => $sc) {
                    $singlec=array();
                    $singlec['id']=$sc->id;
                    if($user->language=="english"){
                        $singlec['name']=$sc->name_en;
                    }
                    if($user->language=="italian"){
                        $singlec['name']=$sc->name_it;
                    }
                    $singlec['image']=$sc->image;
                    $servicesArray=array();
                    $services=ServiceInfo::where('category_id',$sc->id)->get();
                    if(!empty($services)){
                        foreach ($services as $key => $s) {
                            $singles['id']=$s->id;
                            if($user->language=="english"){
                                $singles['name']=$s->name_en;
                            }
                            if($user->language=="italian"){
                                $singles['name']=$s->name_it;
                            }
                            
                            $singles['image']=$s->image;
                            $singles['price']=$s->price;
                            $singles['images']=$s->images;

                            $serviceDynamicArray=array();
                            $serviceFields=ServiceField::orderBy('orderNo','asc')->get();
                            foreach ($serviceFields as $key => $sf) {
                                if(!empty($s[''.$sf->field_name])){
                                    if($user->language=="english"){
                                        $singlesf['label']=$sf->english_label;
                                    }
                                    if($user->language=="italian"){
                                        $singlesf['label']=$sf->italian_label;
                                    }
                                    if($sf->field_type=="string"||$sf->field_type=="description"){
                                        //$single['value']=$info[''.$inf->field_name."_en"];
                                        if($user->language=="english"){
                                            $singlesf['value_it']=$s[''.$sf->field_name."_en"];
                                        }
                                        if($user->language=="italian"){
                                            $singlesf['value_it']=$s[''.$sf->field_name."_it"];
                                        }
                                        
                                    }
                                    if($sf->field_type!="string"&&$sf->field_type!="description"){
                                        $singlesf['value']=$s[''.$sf->field_name];
                                    }
                                    
                                    $singlesf['type']=$sf->field_type;
                                    array_push($serviceDynamicArray,$singlesf);
                                }
                            }
                            $singles['dynamic']=$serviceDynamicArray;
                            array_push($servicesArray,$singles);
                        }
                    }
                    $singlec['services']=$servicesArray;
                    array_push($sca,$singlec);
                }
                $hotel->setAttribute('service_categories',$sca);
            }
            if(empty($serviceCategories)){
                $hotel->setAttribute('service_categories',$sca);
            }
            $reviewsArray=array();
            $ratingsExists=Rating::where('hotel_id',$hotel->id)->exists();
            if($ratingsExists==true){
                $ratingsCount=Rating::where('hotel_id',$hotel->id)->count();
                $hotel->setAttribute('number_of_reviews',$ratingsCount);
                $ratings=Rating::where('hotel_id',$hotel->id)->get();
                $starsSum=0;
                
                foreach($ratings as $rating){
                    $usr=User::find($rating->user_id);
                    if(!empty($usr)){
                        $single=array();
                        $single['user_name']=$usr->name;
                        $single['user_image']=$usr->image;
                        $single['stars']=$rating->stars;
                        $single['comment']=$rating->comment;
                        array_push($reviewsArray,$single);
                        $starsSum=$starsSum+$rating->stars;
                    }
                }
                $starsAverage=$starsSum/$ratingsCount;
                $starsAverage=number_format($starsAverage,1);
                $hotel->setAttribute('average_rating',$starsAverage);
                $hotel->setAttribute('reviews_array',$reviewsArray);
            }
            if($ratingsExists==false){
                $hotel->setAttribute('number_of_reviews',0);
                $hotel->setAttribute('average_rating',0);
                $hotel->setAttribute('reviews_array',$reviewsArray);
            }
            

        }
        return response()->json(['status'=>200,'data'=>$hotels]);
    }
    public function getProductsOfHotel(Request $request){
        if(empty($request->json('hotel_id'))){
            return response()->json(['status'=>401,'message'=>'hotel id is missing']);
        }
        $hotelExists=HotelInfo::where('id',$request->json('hotel_id'))->exists();
        if($hotelExists==false){
            return response()->json(['status'=>401,'message'=>'Hotel does not exists']);    
        }
        $products= ProductInfo::where('hotel_id',$request->json('hotel_id'))->get();
        return response()->json(['status'=>200,'data'=>$products]);
    }
    
    public function getServicesOfHotel(){
        if(empty($request->json('hotel_id'))){
            return response()->json(['status'=>401,'message'=>'hotel id is missing']);
        }
        $hotelExists=HotelInfo::where('id',$request->json('hotel_id'))->exists();
        if($hotelExists==false){
            return response()->json(['status'=>401,'message'=>'Hotel does not exists']);    
        }
        $services= ServiceInfo::where('hotel_id',$request->json('hotel_id'))->get();
        return response()->json(['status'=>200,'data'=>$services]);
    }
   
    
    public function uploadIdImage(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $user=User::find($request->json('user_id'));
        $image=Input::file("image");
        if(!empty($image)){
            $newFilename=$image->getClientOriginalName();
            $destinationPath='customersImages';
            $image->move($destinationPath,$newFilename);
            $picPath='customersImages/' . $newFilename;
            $user->id_image=$picPath;
            $user->save();
        }
        return response()->json(['status'=>200,'message'=>'Uploaded successfully']);
    }
     public function changePassword(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        if(empty($request->json('oldPassword'))||empty($request->json('newPassword'))){
            return response()->json(['status'=>401,'message'=>'Some field is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $user=User::find($request->json('user_id'));
        if($user->password!=$request->json('oldPassword')){
            return response()->json(['status'=>401,'message'=>'Old password does not match.']);
        }
        $user->password=$request->json('newPassword');
        $user->save();
        return response()->json(['status'=>200,'message'=>'Password changed successfully','data'=>$user]);
     } 
     public function forgot(Request $request){
        $exists=User::where('email',$request->json('email'))->exists();
        if($exists==false){
            return response()->json(['status'=>401,'message'=>'Email is incorrect']);
        }
        if($exists==true){
            $user=User::where('email',$request->json('email'))->first();
            $email=$user->email;
            Mail::send('mailf',['user'=>$user], function($message) use($email){
                 $message->to($email)->subject('Geokge');
                 $message->from('pagoda.app@gmail.com');
                
                });
            return response()->json(["status"=>200,'message'=>"L'email per reimpostare la password è stata inviata."]);    
        }
    }
    //latest
    public function getReviews(Request $request){
        if(empty($request->json('hotel_id'))){
            return response()->json(['status'=>401,'message'=>'hotel id is missing']);
        }
        $hotelExists=HotelInfo::where('id',$request->json('hotel_id'))->exists();
        if($hotelExists==false){
            return response()->json(['status'=>401,'message'=>'Hotel does not exists']);    
        }
        $hotel=HotelInfo::find($request->json('hotel_id'));
        $reviewsArray=array();
        $ratingsExists=Rating::where('hotel_id',$hotel->id)->exists();
        if($ratingsExists==true){
            $ratingsCount=Rating::where('hotel_id',$hotel->id)->count();
            $ratings=Rating::where('hotel_id',$hotel->id)->get();
            $starsSum=0;
            
            foreach($ratings as $rating){
                $usr=User::find($rating->user_id);
                if(!empty($usr)){
                    $single=array();
                    $single['user_name']=$usr->name;
                    $single['user_image']=$usr->image;
                    $single['stars']=$rating->stars;
                    $single['comment']=$rating->comment;
                    array_push($reviewsArray,$single);
                    $starsSum=$starsSum+$rating->stars;
                }
            }
            $starsAverage=$starsSum/$ratingsCount;
            $starsAverage=number_format($starsAverage,1);
            return response()->json(['status'=>200,'number_of_reviews'=>$ratingsCount,'average_rating'=>$starsAverage,'reviews_array'=>$reviewsArray]);
        }
        if($ratingsExists==false){
            $reviewsArray=null;
            return response()->json(['status'=>200,'number_of_reviews'=>0,'average_rating'=>0,'reviews_array'=>$reviewsArray]);
        }
    }
    public function getHotelDetail(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $user=User::find($request->json('user_id'));

        $hotel=Account::find($user->associated_hotel_id);

        $info=HotelInfo::where('hotel_id',$hotel->id)->first();
        $hotel->setAttribute('image',$info->image);
        $hotel->setAttribute('logo',$info->logo);
        $hotel->setAttribute('show',$info->showNameOrImage);
        $conditionsE=Condition::where('hotel_id',$hotel->id)->exists();
        if(!empty($conditionsE)){
            $conditions=Condition::where('hotel_id',$hotel->id)->first();
            $hotel->setAttribute('terms_conditions',$conditions);
        }
        if(empty($conditionsE)){
            $hotel->setAttribute('terms_conditions',null);
        }
        
        $infoArray=array();
        if(!empty($info)){
            
            $infoFields=InfoField::orderBy('orderNo','asc')->get();
            foreach ($infoFields as $key => $inf) {
                if(!empty($info[''.$inf->field_name])){
                    if($user->language=="english"){
                        $single['label']=$inf->english_label;
                    }
                    if($user->language=="italian"){
                        $single['label']=$inf->italian_label;
                    }
                    if($inf->field_type=="string"||$inf->field_type=="description"){
                        if($user->language=="english"){
                            $single['value']=$info[''.$inf->field_name."_en"];
                        }
                        if($user->language=="italian"){
                            $single['value']=$info[''.$inf->field_name."_it"];
                        }
                    }
                    if($inf->field_type!="string"&&$inf->field_type!="description"){
                        $single['value']=$info[''.$inf->field_name];
                    }
                    
                    $single['type']=$inf->field_type;
                    array_push($infoArray,$single);
                }
            }
            $hotel->setAttribute('info',$infoArray);
        }
        if(empty($info)){
            $hotel->setAttribute('info',$infoArray);
        }
        //product categories
        $productCategories=Category::where('type','product')->where('hotel_id',$hotel->id)->get();
        $pca=array();
        if(!empty($productCategories)){
            foreach ($productCategories as $key => $pc) {
                $singlec=array();
                $singlec['id']=$pc->id;
                if($user->language=="english"){
                    $singlec['name']=$pc->name_en;
                }
                if($user->language=="italian"){
                    $singlec['name']=$pc->name_it;
                }
                
                $singlec['image']=$pc->image;
                $productsArray=array();
                $products=ProductInfo::where('category_id',$pc->id)->get();
                if(!empty($products)){
                    foreach ($products as $key => $p) {
                        $singlep['id']=$p->id;
                        if($user->language=="english"){
                            $singlep['name']=$p->name_en;
                        }
                        if($user->language=="italian"){
                            $singlep['name']=$p->name_it;
                        }
                        
                        $singlep['image']=$p->image;
                        $singlep['price']=$p->price;
                        $singlep['images']=$p->images;

                        $productDynamicArray=array();
                        $productFields=ProductField::orderBy('orderNo','asc')->get();
                        foreach ($productFields as $key => $pf) {
                            if(!empty($p[''.$pf->field_name])){
                                if($user->language=="english"){
                                    $singlepf['label']=$pf->english_label;
                                }
                                if($user->language=="italian"){
                                    $singlepf['label']=$pf->italian_label;
                                }
                                if($pf->field_type=="string"||$pf->field_type=="description"){
                                    if($user->language=="english"){
                                        $singlepf['value_it']=$p[''.$pf->field_name."_en"];
                                    }
                                    if($user->language=="italian"){
                                        $singlepf['value_it']=$p[''.$pf->field_name."_it"];
                                    }
                                }
                                if($pf->field_type!="string"&&$pf->field_type!="description"){
                                    $singlepf['value']=$p[''.$pf->field_name];
                                }
                                
                                $singlepf['type']=$pf->field_type;
                                array_push($productDynamicArray,$singlepf);
                            }
                        }
                        $singlep['dynamic']=$productDynamicArray;
                        array_push($productsArray,$singlep);
                    }
                }
                $singlec['products']=$productsArray;
                array_push($pca,$singlec);
            }
            $hotel->setAttribute('product_categories',$pca);
        }
        if(empty($productCategories)){
            $hotel->setAttribute('product_categories',$pca);
        }

        //service categories
        $serviceCategories=Category::where('type','service')->where('hotel_id',$hotel->id)->get();
        $sca=array();
        if(!empty($serviceCategories)){
            foreach ($serviceCategories as $key => $sc) {
                $singlec=array();
                $singlec['id']=$sc->id;
                if($user->language=="english"){
                    $singlec['name']=$sc->name_en;
                }
                if($user->language=="italian"){
                    $singlec['name']=$sc->name_it;
                }
                $singlec['image']=$sc->image;
                $servicesArray=array();
                $services=ServiceInfo::where('category_id',$sc->id)->get();
                if(!empty($services)){
                    foreach ($services as $key => $s) {
                        $singles['id']=$s->id;
                        if($user->language=="english"){
                            $singles['name']=$s->name_en;
                        }
                        if($user->language=="italian"){
                            $singles['name']=$s->name_it;
                        }
                        
                        $singles['image']=$s->image;
                        $singles['price']=$s->price;
                        $singles['images']=$s->images;

                        $serviceDynamicArray=array();
                        $serviceFields=ServiceField::orderBy('orderNo','asc')->get();
                        foreach ($serviceFields as $key => $sf) {
                            if(!empty($s[''.$sf->field_name])){
                                if($user->language=="english"){
                                    $singlesf['label']=$sf->english_label;
                                }
                                if($user->language=="italian"){
                                    $singlesf['label']=$sf->italian_label;
                                }
                                if($sf->field_type=="string"||$sf->field_type=="description"){
                                    //$single['value']=$info[''.$inf->field_name."_en"];
                                    if($user->language=="english"){
                                        $singlesf['value_it']=$s[''.$sf->field_name."_en"];
                                    }
                                    if($user->language=="italian"){
                                        $singlesf['value_it']=$s[''.$sf->field_name."_it"];
                                    }
                                    
                                }
                                if($sf->field_type!="string"&&$sf->field_type!="description"){
                                    $singlesf['value']=$s[''.$sf->field_name];
                                }
                                
                                $singlesf['type']=$sf->field_type;
                                array_push($serviceDynamicArray,$singlesf);
                            }
                        }
                        $singles['dynamic']=$serviceDynamicArray;
                        array_push($servicesArray,$singles);
                    }
                }
                $singlec['services']=$servicesArray;
                array_push($sca,$singlec);
            }
            $hotel->setAttribute('service_categories',$sca);
        }
        if(empty($serviceCategories)){
            $hotel->setAttribute('service_categories',$sca);
        }
        $reviewsArray=array();
        $ratingsExists=Rating::where('hotel_id',$hotel->id)->exists();
        if($ratingsExists==true){
            $ratingsCount=Rating::where('hotel_id',$hotel->id)->count();
            $hotel->setAttribute('number_of_reviews',$ratingsCount);
            $ratings=Rating::where('hotel_id',$hotel->id)->get();
            $starsSum=0;
            
            foreach($ratings as $rating){
                $usr=User::find($rating->user_id);
                if(!empty($usr)){
                    $single=array();
                    $single['user_name']=$usr->name;
                    $single['user_image']=$usr->image;
                    $single['stars']=$rating->stars;
                    $single['comment']=$rating->comment;
                    array_push($reviewsArray,$single);
                    $starsSum=$starsSum+$rating->stars;
                }
            }
            $starsAverage=$starsSum/$ratingsCount;
            $starsAverage=number_format($starsAverage,1);
            $hotel->setAttribute('average_rating',$starsAverage);
            $hotel->setAttribute('reviews_array',$reviewsArray);
        }
        if($ratingsExists==false){
            $hotel->setAttribute('number_of_reviews',0);
            $hotel->setAttribute('average_rating',0);
            $hotel->setAttribute('reviews_array',$reviewsArray);
        }  
        return response()->json(['status'=>200,'data'=>$hotel]);
    }
    public function getHotelDetail2(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $user=User::find($request->json('user_id'));
        if(empty($request->json('hotel_id'))){
            return response()->json(['status'=>401,'message'=>'hotel id is missing']);
        }
        $hotelExists=Account::where('id',$request->json('hotel_id'))->exists();
        if($hotelExists==false){
            return response()->json(['status'=>401,'message'=>'Hotel does not exists']); 
        }

        $hotel=Account::find($request->json('hotel_id'));

        $info=HotelInfo::where('hotel_id',$hotel->id)->first();
        $hotel->setAttribute('image',$info->image);
        $hotel->setAttribute('logo',$info->logo);
        $hotel->setAttribute('show',$info->showNameOrImage);
        $conditionsE=Condition::where('hotel_id',$hotel->id)->exists();
        if(!empty($conditionsE)){
            $conditions=Condition::where('hotel_id',$hotel->id)->first();
            $hotel->setAttribute('terms_conditions',$conditions);
        }
        if(empty($conditionsE)){
            $hotel->setAttribute('terms_conditions',null);
        }
        
        $infoArray=array();
        if(!empty($info)){
            
            $infoFields=InfoField::orderBy('orderNo','asc')->get();
            foreach ($infoFields as $key => $inf) {
                if(!empty($info[''.$inf->field_name])){
                    if($user->language=="english"){
                        $single['label']=$inf->english_label;
                    }
                    if($user->language=="italian"){
                        $single['label']=$inf->italian_label;
                    }
                    if($inf->field_type=="string"||$inf->field_type=="description"){
                        if($user->language=="english"){
                            $single['value']=$info[''.$inf->field_name."_en"];
                        }
                        if($user->language=="italian"){
                            $single['value']=$info[''.$inf->field_name."_it"];
                        }
                    }
                    if($inf->field_type!="string"&&$inf->field_type!="description"){
                        $single['value']=$info[''.$inf->field_name];
                    }
                    
                    $single['type']=$inf->field_type;
                    array_push($infoArray,$single);
                }
            }
            $hotel->setAttribute('info',$infoArray);
        }
        if(empty($info)){
            $hotel->setAttribute('info',$infoArray);
        }
        //product categories
        $productCategories=Category::where('type','product')->where('hotel_id',$hotel->id)->get();
        $pca=array();
        if(!empty($productCategories)){
            foreach ($productCategories as $key => $pc) {
                $singlec=array();
                $singlec['id']=$pc->id;
                if($user->language=="english"){
                    $singlec['name']=$pc->name_en;
                }
                if($user->language=="italian"){
                    $singlec['name']=$pc->name_it;
                }
                
                $singlec['image']=$pc->image;
                $productsArray=array();
                $products=ProductInfo::where('category_id',$pc->id)->get();
                if(!empty($products)){
                    foreach ($products as $key => $p) {
                        $singlep['id']=$p->id;
                        if($user->language=="english"){
                            $singlep['name']=$p->name_en;
                        }
                        if($user->language=="italian"){
                            $singlep['name']=$p->name_it;
                        }
                        
                        $singlep['image']=$p->image;
                        $singlep['price']=$p->price;
                        $singlep['images']=$p->images;

                        $productDynamicArray=array();
                        $productFields=ProductField::orderBy('orderNo','asc')->get();
                        foreach ($productFields as $key => $pf) {
                            if(!empty($p[''.$pf->field_name])){
                                if($user->language=="english"){
                                    $singlepf['label']=$pf->english_label;
                                }
                                if($user->language=="italian"){
                                    $singlepf['label']=$pf->italian_label;
                                }
                                if($pf->field_type=="string"||$pf->field_type=="description"){
                                    if($user->language=="english"){
                                        $singlepf['value_it']=$p[''.$pf->field_name."_en"];
                                    }
                                    if($user->language=="italian"){
                                        $singlepf['value_it']=$p[''.$pf->field_name."_it"];
                                    }
                                }
                                if($pf->field_type!="string"&&$pf->field_type!="description"){
                                    $singlepf['value']=$p[''.$pf->field_name];
                                }
                                
                                $singlepf['type']=$pf->field_type;
                                array_push($productDynamicArray,$singlepf);
                            }
                        }
                        $singlep['dynamic']=$productDynamicArray;
                        array_push($productsArray,$singlep);
                    }
                }
                $singlec['products']=$productsArray;
                array_push($pca,$singlec);
            }
            $hotel->setAttribute('product_categories',$pca);
        }
        if(empty($productCategories)){
            $hotel->setAttribute('product_categories',$pca);
        }

        //service categories
        $serviceCategories=Category::where('type','service')->where('hotel_id',$hotel->id)->get();
        $sca=array();
        if(!empty($serviceCategories)){
            foreach ($serviceCategories as $key => $sc) {
                $singlec=array();
                $singlec['id']=$sc->id;
                if($user->language=="english"){
                    $singlec['name']=$sc->name_en;
                }
                if($user->language=="italian"){
                    $singlec['name']=$sc->name_it;
                }
                $singlec['image']=$sc->image;
                $servicesArray=array();
                $services=ServiceInfo::where('category_id',$sc->id)->get();
                if(!empty($services)){
                    foreach ($services as $key => $s) {
                        $singles['id']=$s->id;
                        if($user->language=="english"){
                            $singles['name']=$s->name_en;
                        }
                        if($user->language=="italian"){
                            $singles['name']=$s->name_it;
                        }
                        
                        $singles['image']=$s->image;
                        $singles['price']=$s->price;
                        $singles['images']=$s->images;

                        $serviceDynamicArray=array();
                        $serviceFields=ServiceField::orderBy('orderNo','asc')->get();
                        foreach ($serviceFields as $key => $sf) {
                            if(!empty($s[''.$sf->field_name])){
                                if($user->language=="english"){
                                    $singlesf['label']=$sf->english_label;
                                }
                                if($user->language=="italian"){
                                    $singlesf['label']=$sf->italian_label;
                                }
                                if($sf->field_type=="string"||$sf->field_type=="description"){
                                    //$single['value']=$info[''.$inf->field_name."_en"];
                                    if($user->language=="english"){
                                        $singlesf['value_it']=$s[''.$sf->field_name."_en"];
                                    }
                                    if($user->language=="italian"){
                                        $singlesf['value_it']=$s[''.$sf->field_name."_it"];
                                    }
                                    
                                }
                                if($sf->field_type!="string"&&$sf->field_type!="description"){
                                    $singlesf['value']=$s[''.$sf->field_name];
                                }
                                
                                $singlesf['type']=$sf->field_type;
                                array_push($serviceDynamicArray,$singlesf);
                            }
                        }
                        $singles['dynamic']=$serviceDynamicArray;
                        array_push($servicesArray,$singles);
                    }
                }
                $singlec['services']=$servicesArray;
                array_push($sca,$singlec);
            }
            $hotel->setAttribute('service_categories',$sca);
        }
        if(empty($serviceCategories)){
            $hotel->setAttribute('service_categories',$sca);
        }
        $reviewsArray=array();
        $ratingsExists=Rating::where('hotel_id',$hotel->id)->exists();
        if($ratingsExists==true){
            $ratingsCount=Rating::where('hotel_id',$hotel->id)->count();
            $hotel->setAttribute('number_of_reviews',$ratingsCount);
            $ratings=Rating::where('hotel_id',$hotel->id)->get();
            $starsSum=0;
            
            foreach($ratings as $rating){
                $usr=User::find($rating->user_id);
                if(!empty($usr)){
                    $single=array();
                    $single['user_name']=$usr->name;
                    $single['user_image']=$usr->image;
                    $single['stars']=$rating->stars;
                    $single['comment']=$rating->comment;
                    array_push($reviewsArray,$single);
                    $starsSum=$starsSum+$rating->stars;
                }
            }
            $starsAverage=$starsSum/$ratingsCount;
            $starsAverage=number_format($starsAverage,1);
            $hotel->setAttribute('average_rating',$starsAverage);
            $hotel->setAttribute('reviews_array',$reviewsArray);
        }
        if($ratingsExists==false){
            $hotel->setAttribute('number_of_reviews',0);
            $hotel->setAttribute('average_rating',0);
            $hotel->setAttribute('reviews_array',$reviewsArray);
        }  
        return response()->json(['status'=>200,'data'=>$hotel]);
    }
    
    public function getCategoryOfProducts(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $user=User::find($request->json('user_id'));

        if(empty($request->json('category_id'))){
            return response()->json(['status'=>401,'message'=>'category id is missing']);
        }
        $categoryExists=Category::where('id',$request->json('category_id'))->exists();
        if($categoryExists==false){
            return response()->json(['status'=>401,'message'=>'Category does not exists']);    
        }
        
        //product category
        $pc=Category::find($request->json('category_id'));
        $singlec=array();
        $singlec['id']=$pc->id;
        if($user->language=="english"){
            $singlec['name']=$pc->name_en;
        }
        if($user->language=="italian"){
            $singlec['name']=$pc->name_it;
        }
        
        $singlec['image']=$pc->image;
        $productsArray=array();
        $products=ProductInfo::where('category_id',$pc->id)->get();
        if(!empty($products)){
            foreach ($products as $key => $p) {
                $singlep['id']=$p->id;
                if($user->language=="english"){
                    $singlep['name']=$p->name_en;
                }
                if($user->language=="italian"){
                    $singlep['name']=$p->name_it;
                }
                
                $singlep['image']=$p->image;
                $singlep['price']=$p->price;
                $singlep['images']=$p->images;

                $productDynamicArray=array();
                $productFields=ProductField::orderBy('orderNo','asc')->get();
                foreach ($productFields as $key => $pf) {
                    if(!empty($p[''.$pf->field_name])){
                        if($user->language=="english"){
                            $singlepf['label']=$pf->english_label;
                        }
                        if($user->language=="italian"){
                            $singlepf['label']=$pf->italian_label;
                        }
                        if($pf->field_type=="string"||$pf->field_type=="description"){
                            if($user->language=="english"){
                                $singlepf['value_it']=$p[''.$pf->field_name."_en"];
                            }
                            if($user->language=="italian"){
                                $singlepf['value_it']=$p[''.$pf->field_name."_it"];
                            }
                        }
                        if($pf->field_type!="string"&&$pf->field_type!="description"){
                            $singlepf['value']=$p[''.$pf->field_name];
                        }
                        
                        $singlepf['type']=$pf->field_type;
                        array_push($productDynamicArray,$singlepf);
                    }
                }
                $singlep['dynamic']=$productDynamicArray;
                array_push($productsArray,$singlep);
            }
        }
        $singlec['products']=$productsArray;
           
        return response()->json(['status'=>200,'data'=>$singlec]);
    }
    
    public function getCategoryOfServices(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $user=User::find($request->json('user_id'));
        if(empty($request->json('category_id'))){
            return response()->json(['status'=>401,'message'=>'category id is missing']);
        }
        $categoryExists=Category::where('id',$request->json('category_id'))->exists();
        if($categoryExists==false){
            return response()->json(['status'=>401,'message'=>'Category does not exists']);    
        }
        //service categories
        $sc=Category::find($request->json('category_id'));
        
        $singlec=array();
        $singlec['id']=$sc->id;
        if($user->language=="english"){
            $singlec['name']=$sc->name_en;
        }
        if($user->language=="italian"){
            $singlec['name']=$sc->name_it;
        }
        $singlec['image']=$sc->image;
        $servicesArray=array();
        $services=ServiceInfo::where('category_id',$sc->id)->get();
        if(!empty($services)){
            foreach ($services as $key => $s) {
                $singles['id']=$s->id;
                if($user->language=="english"){
                    $singles['name']=$s->name_en;
                }
                if($user->language=="italian"){
                    $singles['name']=$s->name_it;
                }
                
                $singles['image']=$s->image;
                $singles['price']=$s->price;
                $singles['images']=$s->images;

                $serviceDynamicArray=array();
                $serviceFields=ServiceField::orderBy('orderNo','asc')->get();
                foreach ($serviceFields as $key => $sf) {
                    if(!empty($s[''.$sf->field_name])){
                        if($user->language=="english"){
                            $singlesf['label']=$sf->english_label;
                        }
                        if($user->language=="italian"){
                            $singlesf['label']=$sf->italian_label;
                        }
                        if($sf->field_type=="string"||$sf->field_type=="description"){
                            //$single['value']=$info[''.$inf->field_name."_en"];
                            if($user->language=="english"){
                                $singlesf['value_it']=$s[''.$sf->field_name."_en"];
                            }
                            if($user->language=="italian"){
                                $singlesf['value_it']=$s[''.$sf->field_name."_it"];
                            }
                            
                        }
                        if($sf->field_type!="string"&&$sf->field_type!="description"){
                            $singlesf['value']=$s[''.$sf->field_name];
                        }
                        
                        $singlesf['type']=$sf->field_type;
                        array_push($serviceDynamicArray,$singlesf);
                    }
                }
                $singles['dynamic']=$serviceDynamicArray;
                array_push($servicesArray,$singles);
            }
        }
        $singlec['services']=$servicesArray;
          
        return response()->json(['status'=>200,'data'=>$singlec]);
    }
    public function getProductsOfCategory(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $user=User::find($request->json('user_id'));

        if(empty($request->json('category_id'))){
            return response()->json(['status'=>401,'message'=>'category id is missing']);
        }
        $categoryExists=Category::where('id',$request->json('category_id'))->exists();
        if($categoryExists==false){
            return response()->json(['status'=>401,'message'=>'Category does not exists']);    
        }
        $category=Category::find($request->json('category_id'));
        $productsArray=array();
        $products=ProductInfo::where('category_id',$category->id)->get();
        if(!empty($products)){
            foreach ($products as $key => $p) {
                $singlep['id']=$p->id;
                if($user->language=="english"){
                    $singlep['name']=$p->name_en;
                }
                if($user->language=="italian"){
                    $singlep['name']=$p->name_it;
                }
                
                $singlep['image']=$p->image;
                $singlep['price']=$p->price;
                $singlep['images']=$p->images;

                $productDynamicArray=array();
                $productFields=ProductField::orderBy('orderNo','asc')->get();
                foreach ($productFields as $key => $pf) {
                    if(!empty($p[''.$pf->field_name])){
                        if($user->language=="english"){
                            $singlepf['label']=$pf->english_label;
                        }
                        if($user->language=="italian"){
                            $singlepf['label']=$pf->italian_label;
                        }
                        if($pf->field_type=="string"||$pf->field_type=="description"){
                            if($user->language=="english"){
                                $singlepf['value_it']=$p[''.$pf->field_name."_en"];
                            }
                            if($user->language=="italian"){
                                $singlepf['value_it']=$p[''.$pf->field_name."_it"];
                            }
                        }
                        if($pf->field_type!="string"&&$pf->field_type!="description"){
                            $singlepf['value']=$p[''.$pf->field_name];
                        }
                        
                        $singlepf['type']=$pf->field_type;
                        array_push($productDynamicArray,$singlepf);
                    }
                }
                $singlep['dynamic']=$productDynamicArray;
                array_push($productsArray,$singlep);
            }
        }   
        return response()->json(['status'=>200,'data'=>$productsArray]);
    }
    public function getServicesOfCategory(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $user=User::find($request->json('user_id'));

        if(empty($request->json('category_id'))){
            return response()->json(['status'=>401,'message'=>'category id is missing']);
        }
        $categoryExists=Category::where('id',$request->json('category_id'))->exists();
        if($categoryExists==false){
            return response()->json(['status'=>401,'message'=>'Category does not exists']);    
        }
        
        $servicesArray=array();
        $services=ServiceInfo::where('category_id',$request->json('category_id'))->get();
        if(!empty($services)){
            foreach ($services as $key => $s) {
                $singles['id']=$s->id;
                if($user->language=="english"){
                    $singles['name']=$s->name_en;
                }
                if($user->language=="italian"){
                    $singles['name']=$s->name_it;
                }
                
                $singles['image']=$s->image;
                $singles['price']=$s->price;
                $singles['images']=$s->images;

                $serviceDynamicArray=array();
                $serviceFields=ServiceField::orderBy('orderNo','asc')->get();
                foreach ($serviceFields as $key => $sf) {
                    if(!empty($s[''.$sf->field_name])){
                        if($user->language=="english"){
                            $singlesf['label']=$sf->english_label;
                        }
                        if($user->language=="italian"){
                            $singlesf['label']=$sf->italian_label;
                        }
                        if($sf->field_type=="string"||$sf->field_type=="description"){
                            //$single['value']=$info[''.$inf->field_name."_en"];
                            if($user->language=="english"){
                                $singlesf['value_it']=$s[''.$sf->field_name."_en"];
                            }
                            if($user->language=="italian"){
                                $singlesf['value_it']=$s[''.$sf->field_name."_it"];
                            }
                            
                        }
                        if($sf->field_type!="string"&&$sf->field_type!="description"){
                            $singlesf['value']=$s[''.$sf->field_name];
                        }
                        
                        $singlesf['type']=$sf->field_type;
                        array_push($serviceDynamicArray,$singlesf);
                    }
                }
                $singles['dynamic']=$serviceDynamicArray;
                array_push($servicesArray,$singles);
            }
        } 
        return response()->json(['status'=>200,'data'=>$servicesArray]);
    }

    public function getProductDetail(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }
        $user=User::find($request->json('user_id'));
        if(empty($request->json('product_id'))){
            return response()->json(['status'=>401,'message'=>'product id is missing']);
        }
        $productExists=ProductInfo::where('id',$request->json('product_id'))->exists();
        if($productExists==false){
            return response()->json(['status'=>401,'message'=>'Product does not exists']); 
        }
        $p=ProductInfo::find($request->json('product_id'));
        $singlep['id']=$p->id;
        if($user->language=="english"){
            $singlep['name']=$p->name_en;
        }
        if($user->language=="italian"){
            $singlep['name']=$p->name_it;
        }
        
        $singlep['image']=$p->image;
        $singlep['price']=$p->price;
        $singlep['images']=$p->images;

        $productDynamicArray=array();
        $productFields=ProductField::orderBy('orderNo','asc')->get();
        foreach ($productFields as $key => $pf) {
            if(!empty($p[''.$pf->field_name])){
                if($user->language=="english"){
                    $singlepf['label']=$pf->english_label;
                }
                if($user->language=="italian"){
                    $singlepf['label']=$pf->italian_label;
                }
                if($pf->field_type=="string"||$pf->field_type=="description"){
                    if($user->language=="english"){
                        $singlepf['value_it']=$p[''.$pf->field_name."_en"];
                    }
                    if($user->language=="italian"){
                        $singlepf['value_it']=$p[''.$pf->field_name."_it"];
                    }
                }
                if($pf->field_type!="string"&&$pf->field_type!="description"){
                    $singlepf['value']=$p[''.$pf->field_name];
                }
                
                $singlepf['type']=$pf->field_type;
                array_push($productDynamicArray,$singlepf);
            }
        }
        $singlep['dynamic']=$productDynamicArray;
         

        return response()->json(['status'=>200,'data'=>$singlep]);
    }
    public function getServiceDetail(Request $request){
        if(empty($request->json('user_id'))){
            return response()->json(['status'=>401,'message'=>'user id is missing']);
        }
        $userExists=User::where('id',$request->json('user_id'))->exists();
        if($userExists==false){
            return response()->json(['status'=>401,'message'=>'User does not exists']); 
        }

        $user=User::find($request->json('user_id'));
        if(empty($request->json('service_id'))){
            return response()->json(['status'=>401,'message'=>'service id is missing']);
        }
        $serviceExists=ServiceInfo::where('id',$request->json('service_id'))->exists();
        if($serviceExists==false){
            return response()->json(['status'=>401,'message'=>'Service does not exists']); 
        }
        $s=ServiceInfo::find($request->json('service_id'));
        
        $singles['id']=$s->id;
        if($user->language=="english"){
            $singles['name']=$s->name_en;
        }
        if($user->language=="italian"){
            $singles['name']=$s->name_it;
        }
        
        $singles['image']=$s->image;
        $singles['price']=$s->price;
        $singles['images']=$s->images;

        $serviceDynamicArray=array();
        $serviceFields=ServiceField::orderBy('orderNo','asc')->get();
        foreach ($serviceFields as $key => $sf) {
            if(!empty($s[''.$sf->field_name])){
                if($user->language=="english"){
                    $singlesf['label']=$sf->english_label;
                }
                if($user->language=="italian"){
                    $singlesf['label']=$sf->italian_label;
                }
                if($sf->field_type=="string"||$sf->field_type=="description"){
                    //$single['value']=$info[''.$inf->field_name."_en"];
                    if($user->language=="english"){
                        $singlesf['value_it']=$s[''.$sf->field_name."_en"];
                    }
                    if($user->language=="italian"){
                        $singlesf['value_it']=$s[''.$sf->field_name."_it"];
                    }
                    
                }
                if($sf->field_type!="string"&&$sf->field_type!="description"){
                    $singlesf['value']=$s[''.$sf->field_name];
                }
                
                $singlesf['type']=$sf->field_type;
                array_push($serviceDynamicArray,$singlesf);
            }
        }
        $singles['dynamic']=$serviceDynamicArray;
        return response()->json(['status'=>200,'data'=>$singles]);
    }
}
