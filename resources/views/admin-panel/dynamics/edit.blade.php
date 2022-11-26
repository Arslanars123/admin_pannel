<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$dynamic->labels}}</a></li>
            <!--<li class="breadcrumb-item active" aria-current="page"><span>Striped</span></li>-->
        </ol>
    </nav>
@endsection
@section('content')
<div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="row layout-top-spacing" id="cancel-row">
                   <div class="col-lg-12 col-12  layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">                                
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>{{$dynamic->labels}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form style="padding: 5%;" method="POST" action="{{url('dynamics-update')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Main Logo</label>
                                        <input type="file" name="main_logo">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Main Logo Title</label>
                                        <input type="text" name="main_logo_title" class="form-control" id="formGroupExampleInput" placeholder="Enter Main Logo Title" value="@if(!empty($dynamic->main_logo_title)){{$dynamic->main_logo_title}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Hotels Accounts Label</label>
                                        <input type="text" name="hotels_accounts" class="form-control" id="formGroupExampleInput" placeholder="Enter hotels accounts label" value="@if(!empty($dynamic->hotels_accounts)){{$dynamic->hotels_accounts}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Hotels Info Fields Label</label>
                                        <input type="text" name="hotels_info_fields" class="form-control" id="formGroupExampleInput" placeholder="Enter hotels info fields label" value="@if(!empty($dynamic->hotels_info_fields)){{$dynamic->hotels_info_fields}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Customers Fields Label</label>
                                        <input type="text" name="customers_fields" class="form-control" id="formGroupExampleInput" placeholder="Enter customers fields label" value="@if(!empty($dynamic->customers_fields)){{$dynamic->customers_fields}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Products Fields Label</label>
                                        <input type="text" name="products_fields" class="form-control" id="formGroupExampleInput" placeholder="Enter products fields label" value="@if(!empty($dynamic->products_fields)){{$dynamic->products_fields}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Services Fields Label</label>
                                        <input type="text" name="services_fields" class="form-control" id="formGroupExampleInput" placeholder="Enter services fields label" value="@if(!empty($dynamic->services_fields)){{$dynamic->services_fields}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Customers Label</label>
                                        <input type="text" name="customers" class="form-control" id="formGroupExampleInput" placeholder="Enter customers label" value="@if(!empty($dynamic->customers)){{$dynamic->customers}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Products Label</label>
                                        <input type="text" name="products" class="form-control" id="formGroupExampleInput" placeholder="Enter products label" value="@if(!empty($dynamic->products)){{$dynamic->products}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Services Label</label>
                                        <input type="text" name="services" class="form-control" id="formGroupExampleInput" placeholder="Enter services label" value="@if(!empty($dynamic->services)){{$dynamic->services}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Categories Label</label>
                                        <input type="text" name="categories" class="form-control" id="formGroupExampleInput" placeholder="Enter categories label" value="@if(!empty($dynamic->categories)){{$dynamic->categories}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Hotel Information Label</label>
                                        <input type="text" name="hotel_information" class="form-control" id="formGroupExampleInput" placeholder="Enter hotel information label" value="@if(!empty($dynamic->hotel_information)){{$dynamic->hotel_information}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Ratings Label</label>
                                        <input type="text" name="ratings" class="form-control" id="formGroupExampleInput" placeholder="Enter ratings label" value="@if(!empty($dynamic->ratings)){{$dynamic->ratings}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Chat Label</label>
                                        <input type="text" name="chat" class="form-control" id="formGroupExampleInput" placeholder="Enter chat label" value="@if(!empty($dynamic->chat)){{$dynamic->chat}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Services Reservations Calender Label</label>
                                        <input type="text" name="services_reservations_calender" class="form-control" id="formGroupExampleInput" placeholder="Enter services reservations calender label" value="@if(!empty($dynamic->services_reservations_calender)){{$dynamic->services_reservations_calender}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Bookings Label</label>
                                        <input type="text" name="bookings" class="form-control" id="formGroupExampleInput" placeholder="Enter bookings label" value="@if(!empty($dynamic->bookings)){{$dynamic->bookings}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Services Reservations Label</label>
                                        <input type="text" name="services_reservations" class="form-control" id="formGroupExampleInput" placeholder="Enter services reservations label" value="@if(!empty($dynamic->services_reservations)){{$dynamic->services_reservations}}@endif" required="required">
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">English Label</label>
                                        <input type="text" name="english_label" class="form-control" id="formGroupExampleInput" placeholder="Enter english label" value="@if(!empty($dynamic->english_label)){{$dynamic->english_label}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Italian Label</label>
                                        <input type="text" name="italian_label" class="form-control" id="formGroupExampleInput" placeholder="Enter italian label" value="@if(!empty($dynamic->italian_label)){{$dynamic->italian_label}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Is Mandatory Label</label>
                                        <input type="text" name="is_mandatory" class="form-control" id="formGroupExampleInput" placeholder="Enter is mandatory label" value="@if(!empty($dynamic->is_mandatory)){{$dynamic->is_mandatory}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Field Type Label</label>
                                        <input type="text" name="field_type" class="form-control" id="formGroupExampleInput" placeholder="Enter field type label" value="@if(!empty($dynamic->field_type)){{$dynamic->field_type}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Summary Label</label>
                                        <input type="text" name="summary" class="form-control" id="formGroupExampleInput" placeholder="Enter summary label" value="@if(!empty($dynamic->summary)){{$dynamic->summary}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Copyright Text</label>
                                        <input type="text" name="copyright" class="form-control" id="formGroupExampleInput" placeholder="Enter copyright label" value="@if(!empty($dynamic->copyright)){{$dynamic->copyright}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Name Label</label>
                                        <input type="text" name="name" class="form-control" id="formGroupExampleInput" placeholder="Enter name label" value="@if(!empty($dynamic->name)){{$dynamic->name}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Email Label</label>
                                        <input type="text" name="email" class="form-control" id="formGroupExampleInput" placeholder="Enter email label" value="@if(!empty($dynamic->email)){{$dynamic->email}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Password Label</label>
                                        <input type="text" name="password" class="form-control" id="formGroupExampleInput" placeholder="Enter password label" value="@if(!empty($dynamic->password)){{$dynamic->password}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Phone Label</label>
                                        <input type="text" name="phone" class="form-control" id="formGroupExampleInput" placeholder="Enter phone label" value="@if(!empty($dynamic->phone)){{$dynamic->phone}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Adults Label</label>
                                        <input type="text" name="adults" class="form-control" id="formGroupExampleInput" placeholder="Enter adults label" value="@if(!empty($dynamic->adults)){{$dynamic->adults}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Children Label</label>
                                        <input type="text" name="children" class="form-control" id="formGroupExampleInput" placeholder="Enter children label" value="@if(!empty($dynamic->children)){{$dynamic->children}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Image Label</label>
                                        <input type="text" name="image" class="form-control" id="formGroupExampleInput" placeholder="Enter products label" value="@if(!empty($dynamic->image)){{$dynamic->image}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Price Label</label>
                                        <input type="text" name="price" class="form-control" id="formGroupExampleInput" placeholder="Enter price label" value="@if(!empty($dynamic->price)){{$dynamic->price}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Create Label</label>
                                        <input type="text" name="createl" class="form-control" id="formGroupExampleInput" placeholder="Enter create label" value="@if(!empty($dynamic->createl)){{$dynamic->createl}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Edit Label</label>
                                        <input type="text" name="editl" class="form-control" id="formGroupExampleInput" placeholder="Enter edit label" value="@if(!empty($dynamic->editl)){{$dynamic->editl}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Delete Label</label>
                                        <input type="text" name="deletel" class="form-control" id="formGroupExampleInput" placeholder="Enter delete label" value="@if(!empty($dynamic->deletel)){{$dynamic->deletel}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Sign out Label</label>
                                        <input type="text" name="signout" class="form-control" id="formGroupExampleInput" placeholder="Enter sign out label" value="@if(!empty($dynamic->signout)){{$dynamic->signout}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Title Label</label>
                                        <input type="text" name="title" class="form-control" id="formGroupExampleInput" placeholder="Enter title label" value="@if(!empty($dynamic->title)){{$dynamic->title}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Description Label</label>
                                        <input type="text" name="description" class="form-control" id="formGroupExampleInput" placeholder="Enter description label" value="@if(!empty($dynamic->description)){{$dynamic->description}}@endif" required="required">
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Actions Label</label>
                                        <input type="text" name="actions" class="form-control" id="formGroupExampleInput" placeholder="Enter actions label" value="@if(!empty($dynamic->actions)){{$dynamic->actions}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Email Templates Label</label>
                                        <input type="text" name="email_templates" class="form-control" id="formGroupExampleInput" placeholder="Enter email templates label" value="@if(!empty($dynamic->email_templates)){{$dynamic->email_templates}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Send Email To (Hotels) Label</label>
                                        <input type="text" name="send_email_hotels" class="form-control" id="formGroupExampleInput" placeholder="Enter send email to hotels label" value="@if(!empty($dynamic->send_email_hotels)){{$dynamic->send_email_hotels}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Send Email To (Customers) Label</label>
                                        <input type="text" name="send_email_customers" class="form-control" id="formGroupExampleInput" placeholder="Enter send email to customers label" value="@if(!empty($dynamic->send_email_customers)){{$dynamic->send_email_customers}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Labels Label</label>
                                        <input type="text" name="labels" class="form-control" id="formGroupExampleInput" placeholder="Enter labels label" value="@if(!empty($dynamic->labels)){{$dynamic->labels}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Reserve Service Label</label>
                                        <input type="text" name="reserve_service" class="form-control" id="formGroupExampleInput" placeholder="Enter reserve service label" value="@if(!empty($dynamic->reserve_service)){{$dynamic->reserve_service}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Reservations Label</label>
                                        <input type="text" name="reservations" class="form-control" id="formGroupExampleInput" placeholder="Enter reservations label" value="@if(!empty($dynamic->reservations)){{$dynamic->reservations}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Select Service Label</label>
                                        <input type="text" name="select_service" class="form-control" id="formGroupExampleInput" placeholder="Enter select service label" value="@if(!empty($dynamic->select_service)){{$dynamic->select_service}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Select Customer Label</label>
                                        <input type="text" name="select_customer" class="form-control" id="formGroupExampleInput" placeholder="Enter select customer label" value="@if(!empty($dynamic->select_customer)){{$dynamic->select_customer}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Select Product Label</label>
                                        <input type="text" name="select_product" class="form-control" id="formGroupExampleInput" placeholder="Enter select product label" value="@if(!empty($dynamic->select_product)){{$dynamic->select_product}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Select Template Label</label>
                                        <input type="text" name="select_template" class="form-control" id="formGroupExampleInput" placeholder="Enter select template label" value="@if(!empty($dynamic->select_template)){{$dynamic->select_template}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Select Hotel Label</label>
                                        <input type="text" name="select_hotel" class="form-control" id="formGroupExampleInput" placeholder="Enter select hotel label" value="@if(!empty($dynamic->select_hotel)){{$dynamic->select_hotel}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Reserve Date Label</label>
                                        <input type="text" name="reserve_date" class="form-control" id="formGroupExampleInput" placeholder="Enter reserve date label" value="@if(!empty($dynamic->reserve_date)){{$dynamic->reserve_date}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Event Date Label</label>
                                        <input type="text" name="event_date" class="form-control" id="formGroupExampleInput" placeholder="Enter event date label" value="@if(!empty($dynamic->event_date)){{$dynamic->event_date}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Number Of People Label</label>
                                        <input type="text" name="number_of_people" class="form-control" id="formGroupExampleInput" placeholder="Enter number of people label" value="@if(!empty($dynamic->number_of_people)){{$dynamic->number_of_people}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Number Of Children Label</label>
                                        <input type="text" name="number_of_children" class="form-control" id="formGroupExampleInput" placeholder="Enter number of children label" value="@if(!empty($dynamic->number_of_children)){{$dynamic->number_of_children}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Hours From Label</label>
                                        <input type="text" name="hours_from" class="form-control" id="formGroupExampleInput" placeholder="Enter hours from label" value="@if(!empty($dynamic->hours_from)){{$dynamic->hours_from}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Hours To Label</label>
                                        <input type="text" name="hours_to" class="form-control" id="formGroupExampleInput" placeholder="Enter hours to label" value="@if(!empty($dynamic->hours_to)){{$dynamic->hours_to}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Add Label</label>
                                        <input type="text" name="addl" class="form-control" id="formGroupExampleInput" placeholder="Enter add label" value="@if(!empty($dynamic->addl)){{$dynamic->addl}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Type Label</label>
                                        <input type="text" name="type" class="form-control" id="formGroupExampleInput" placeholder="Enter type label" value="@if(!empty($dynamic->type)){{$dynamic->type}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Customer Name Label</label>
                                        <input type="text" name="customer_name" class="form-control" id="formGroupExampleInput" placeholder="Enter customer name label" value="@if(!empty($dynamic->customer_name)){{$dynamic->customer_name}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Service Name Label</label>
                                        <input type="text" name="service_name" class="form-control" id="formGroupExampleInput" placeholder="Enter service name label" value="@if(!empty($dynamic->service_name)){{$dynamic->service_name}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Product Name Label</label>
                                        <input type="text" name="product_name" class="form-control" id="formGroupExampleInput" placeholder="Enter product name label" value="@if(!empty($dynamic->product_name)){{$dynamic->product_name}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Hotel Name Label</label>
                                        <input type="text" name="hotel_name" class="form-control" id="formGroupExampleInput" placeholder="Enter hotel name label" value="@if(!empty($dynamic->hotel_name)){{$dynamic->hotel_name}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Order No Label</label>
                                        <input type="text" name="order_no" class="form-control" id="formGroupExampleInput" placeholder="Enter order no label" value="@if(!empty($dynamic->order_no)){{$dynamic->order_no}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Dropdown Items Label</label>
                                        <input type="text" name="dropdown_items" class="form-control" id="formGroupExampleInput" placeholder="Enter dropdown items label" value="@if(!empty($dynamic->dropdown_items)){{$dynamic->dropdown_items}}@endif" required="required">
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Total Price Label</label>
                                        <input type="text" name="total_price" class="form-control" id="formGroupExampleInput" placeholder="Enter total price label" value="@if(!empty($dynamic->total_price)){{$dynamic->total_price}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Print Summary Label</label>
                                        <input type="text" name="print_summary" class="form-control" id="formGroupExampleInput" placeholder="Enter print summary label" value="@if(!empty($dynamic->print_summary)){{$dynamic->print_summary}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Take PDF Label</label>
                                        <input type="text" name="take_pdf" class="form-control" id="formGroupExampleInput" placeholder="Enter take pdf label" value="@if(!empty($dynamic->take_pdf)){{$dynamic->take_pdf}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Creation Date & Time Label</label>
                                        <input type="text" name="creation_date_time" class="form-control" id="formGroupExampleInput" placeholder="Enter creation date & time label" value="@if(!empty($dynamic->creation_date_time)){{$dynamic->creation_date_time}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Stars Label</label>
                                        <input type="text" name="stars" class="form-control" id="formGroupExampleInput" placeholder="Enter stars label" value="@if(!empty($dynamic->stars)){{$dynamic->stars}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Comment Label</label>
                                        <input type="text" name="comment" class="form-control" id="formGroupExampleInput" placeholder="Enter comment label" value="@if(!empty($dynamic->comment)){{$dynamic->comment}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Reservation Code</label>
                                        <input type="text" name="reservation_code" class="form-control" id="formGroupExampleInput" placeholder="Enter reservation code label" value="@if(!empty($dynamic->reservation_code)){{$dynamic->reservation_code}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Save And Exit</label>
                                        <input type="text" name="save_exit" class="form-control" id="formGroupExampleInput" placeholder="Enter save and exit label" value="@if(!empty($dynamic->save_exit)){{$dynamic->save_exit}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Save And Stay</label>
                                        <input type="text" name="save_stay" class="form-control" id="formGroupExampleInput" placeholder="Enter save and stay label" value="@if(!empty($dynamic->save_stay)){{$dynamic->save_stay}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">GO BACK WITHOUT SAVING</label>
                                        <input type="text" name="go_back" class="form-control" id="formGroupExampleInput" placeholder="Enter GO BACK WITHOUT SAVING label" value="@if(!empty($dynamic->go_back)){{$dynamic->go_back}}@endif" required="required">
                                    </div>
                                    
                                    
                                    
                                    

                                    
                                    
                                    
                                    
                                    
                                    <input type="submit" value="Store" class="btn btn-primary">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection