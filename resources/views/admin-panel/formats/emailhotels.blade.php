<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$dynamic->send_email_hotel}}</a></li>
            
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
                                        <h4>{{$dynamic->send_email_hotel}}</h4>
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
                                <form style="padding: 5%;" method="POST" action="{{url('send-hotels')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group mb-4">
                                        <?php
                                            $formats=\App\Models\Format::all();
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
                                            $hotels=\App\Models\Account::all();
                                         ?>
                                        <label for="formGroupExampleInput2">{{$dynamic->select_hotel}}</label>
                                        <select name="hotels[]" class="form-control" required="required" multiple="multiple">
                                            <option value="">Choose here</option>
                                            @foreach($hotels as $hotel)
                                            <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-4">
                                        <?php
                                            $products=\App\Models\ProductInfo::all();
                                         ?>
                                        <label for="formGroupExampleInput2">{{$dynamic->select_product}}</label>
                                        <select name="productId" class="form-control" required="required">
                                            <option value="">Choose here</option>
                                            @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-4">
                                        <?php
                                            $services=\App\Models\ServiceInfo::all();
                                         ?>
                                        <label for="formGroupExampleInput2">{{$dynamic->select_service}}</label>
                                        <select name="serviceId" class="form-control" required="required">
                                            <option value="">Choose here</option>
                                            @foreach($services as $service)
                                            <option value="{{$service->id}}">{{$service->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-4"> 
                                        <label for="formGroupExampleInput2">Sender Email</label>
                                        <input type="email" name="email" class="form-control" required="required">
                                    </div>
                                    <div class="form-group mb-4"> 
                                        <label for="formGroupExampleInput2">Sender Name</label>
                                        <input type="text" name="name" class="form-control" required="required">
                                    </div>



                                    
                                    <button name="sav" class="btn btn-primary" value="SAVE AND EXIT" type="submit">SAVE</button>
                                   
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection