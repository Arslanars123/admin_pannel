<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$dynamic->send_email_customers}}</a></li>
            
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
                                        <h4>{{$dynamic->send_email_customers}}</h4>
                                    </div>
                                </div>
                            </div>
                            @if (\Session::has('message'))
                            <div class="alert alert-success alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <!--<h5><i class="icon fas fa-check"></i> Alerta !</h5>-->
                                  {!! \Session::get('message') !!}
                            </div>
                            @endif
                            @if (\Session::has('message2'))
                            <div class="alert alert-danger alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <!--<h5><i class="icon fas fa-check"></i> Alerta !</h5>-->
                                  {!! \Session::get('message2') !!}
                            </div>
                            @endif
                            <div class="widget-content widget-content-area">
                                <form style="padding: 5%;" method="POST" action="{{url('send-customers')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group mb-4">
                                        <?php
                                            if(Auth::user()->role=="super-admin"){
                                            $formats=\App\Models\Format::all();
                                            }

                                            if(Auth::user()->role=="hotel-manager"){
                                               $formats=\App\Models\Format::where('associated_hotel_id',Auth::user()->associated_hotel_id)->orWhere('associated_hotel_id',null)->get();
                                            }
                                         ?>
                                        <label for="formGroupExampleInput2">{{$dynamic->select_template}}</label>
                                        <select name="format" class="form-control" required="required">
                                            <option value="">Choose here</option>
                                            @foreach($formats as $format)
                                            <option value="{{$format->id}}">{{$format->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-4">
                                        <?php
                                            if(Auth::user()->role=="hotel-manager"){
                                                $customers=\App\Models\User::where('role','customer')->where('associated_hotel_id',Auth::user()->associated_hotel_id)->get();
                                            }
                                            if(Auth::user()->role=="super-admin"){
                                                $customers=\App\Models\User::where('role','customer')->get();
                                            }
                                         ?>
                                        <label for="formGroupExampleInput2">{{$dynamic->select_customer}}</label>
                                        <select name="customers[]" class="form-control" required="required" multiple="multiple">
                                            <option value="">Choose here</option>
                                            @foreach($customers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-4">
                                        <?php
                                            if(Auth::user()->role=="super-admin"){
                                                $products=\App\Models\ProductInfo::all();
                                            }
                                            if(Auth::user()->role=="hotel-manager"){
                                                $products=\App\Models\ProductInfo::where('hotel_id',Auth::user()->associated_hotel_id)->get();

                                            }
                                         ?>
                                        <label for="formGroupExampleInput2">{{$dynamic->select_product}}</label>
                                        <select name="productId" class="form-control">
                                            <option value="">Choose here</option>
                                            @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-4">
                                        <?php
                                            if(Auth::user()->role=="super-admin"){
                                                $services=\App\Models\ServiceInfo::all();
                                            }
                                            if(Auth::user()->role=="hotel-manager"){
                                                $services=\App\Models\ServiceInfo::where('hotel_id',Auth::user()->associated_hotel_id)->get();

                                            }
                                         ?>
                                        <label for="formGroupExampleInput2">{{$dynamic->select_service}}</label>
                                        <select name="serviceId" class="form-control">
                                            <option value="">Choose here</option>
                                            @foreach($services as $service)
                                            <option value="{{$service->id}}">{{$service->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @if(Auth::user()->role=="hotel-manager")
                                    <input type="hidden" name="email" value="{{Auth::user()->email}}">
                                    <input type="hidden" name="name" value="{{Auth::user()->name}}">
                                    @endif
                                    @if(Auth::user()->role=="super-admin")
                                    <div class="form-group mb-4"> 
                                        <label for="formGroupExampleInput2">Sender Email</label>
                                        <input type="email" name="email" class="form-control" required="required">
                                    </div>
                                    <div class="form-group mb-4"> 
                                        <label for="formGroupExampleInput2">Sender Name</label>
                                        <input type="text" name="name" class="form-control" required="required">
                                    </div>
                                    @endif



                                    
                                    <button name="sav" class="btn btn-primary" value="SAVE AND EXIT" type="submit">SAVE</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection