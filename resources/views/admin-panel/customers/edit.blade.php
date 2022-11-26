<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$dynamic->customers}}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>{{$dynamic->editl}}</span></li>
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
                                        <h4>{{$dynamic->edit}} {{$dynamic->customers}}</h4>
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
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form style="padding: 5%;" method="POST" action="{{url('customers-update/'.$customer->id)}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$dynamic->name}}</label>
                                        <input type="text" name="name" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($customer->name)){{$customer->name}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$dynamic->email}}</label>
                                        <input type="text" name="email" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($customer->email)){{$customer->email}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$dynamic->password}}</label>
                                        <input type="text" name="password" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($customer->password)){{$customer->password}}@endif" required="required">
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$dynamic->phone}}</label>
                                        <input type="text" name="phone" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($customer->phone)){{$customer->phone}}@endif" required="required">
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$dynamic->adults}}</label>
                                        <input type="text" name="adults" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($customer->adults)){{$customer->adults}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$dynamic->children}}</label>
                                        <input type="text" name="children" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($customer->children)){{$customer->children}}@endif" required="required">
                                    </div>
                                    @if(!empty($customer->image))
                                    <img src="{{asset($customer->image)}}" style="width: 70px;">
                                    @endif
                                    
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$dynamic->image}}</label>
                                        <input type="file" name="image" class="form-control" id="formGroupExampleInput">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Date from</label>
                                        <input type="date" value="@if(!empty($customer->dateFrom)){{$customer->dateFrom}}@endif" name="dateFrom" class="form-control" id="formGroupExampleInput" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Date To</label>
                                        <input type="date" name="dateTo" value="@if(!empty($customer->dateTo)){{$customer->dateTo}}@endif" class="form-control" id="formGroupExampleInput" required="required">
                                    </div>
                                    <?php
                                        $fields=\App\Models\CustomerField::all();
                                     ?>
                                     @foreach($fields as $field)
                                     @if($field->field_type=="string")
                                     <?php
                                        $nam_en=$field->field_name."_en";
                                        $nam_it=$field->field_name."_it";
                                      ?>
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}}</label>
                                        <input type="text" name="{{$nam_en}}" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($customer[$nam_en])){{$customer[$nam_en]}}@endif" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}}</label>
                                        <input type="text" name="{{$nam_it}}" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($customer[$nam_it])){{$customer[$nam_it]}}@endif" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif

                                     @if($field->field_type=="description")
                                     <?php
                                        $nam_en=$field->field_name."_en";
                                        $nam_it=$field->field_name."_it";
                                        
                                      ?>
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}}</label>
                                        <textarea id="demo1" name="{{$nam_en}}" @if($field->is_mandatory=="Yes") required="required" @endif >@if(!empty($information[$nam_en])){{$information[$nam_en]}}@endif</textarea>
                                        
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->italian_label}}</label>
                                        <textarea id="demo2" name="{{$nam_it}}" @if($field->is_mandatory=="Yes") required="required" @endif >@if(!empty($information[$nam_it])){{$information[$nam_it]}}@endif</textarea>
                                        
                                    </div>
                                     @endif

                                     @if($field->field_type=="integer")
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}} / {{$field->italian_label}}</label>
                                        <input type="number" name="{{$field->field_name}}" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($customer[$field->field_name])){{$customer[$field->field_name]}}@endif" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif

                                     @if($field->field_type=="date")
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}}</label>
                                        <input type="date" name="{{$field->field_name}}" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($customer[$field->field_name])){{$customer[$field->field_name]}}@endif" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif

                                     @if($field->field_type=="time")
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}} / {{$field->italian_label}}</label>
                                        <input type="time" name="{{$field->field_name}}" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($customer[$field->field_name])){{$customer[$field->field_name]}}@endif" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif

                                     @if($field->field_type=="dropdown")
                                     <?php
                                        $items=\App\Models\Dropdown::where('table_name','customersinformations')->where('column_name',$field->field_name)->get();
                                      ?>
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}} / {{$field->italian_label}}</label>
                                        <select name="{{$field->field_name}}" class="form-control" @if($field->is_mandatory=="Yes") required="required" @endif >
                                            @if(!empty($items))
                                            <option value="">Choose here</option>
                                            @foreach($items as $item)
                                            <option value="{{$item->item_name}}" @if($customer[$field->field_name]==$item->item_name) selected @endif>{{$item->item_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                     @endif

                                     @if($field->field_type=="file")
                                     @if(!empty($customer[$field->field_name]))
                                     <a href="{{asset($customer[$field->field_name])}}" target="_blank">Download File</a>

                                     @endif
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}} / {{$field->italian_label}}</label>
                                        <input type="file" name="{{$field->field_name}}" class="form-control" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif
                                     @endforeach
                                    
                                    <!--<input type="submit" value="Store" class="btn btn-primary">-->
                                    <button name="sav" class="btn btn-primary" value="SAVE AND EXIT" type="submit">{{$dynamic->save_exit}}</button>
                                    <button name="sav" class="btn btn-secondary" value="SAVE AND STAY" type="submit">{{$dynamic->save_stay}}</button>
                                    <a href="{{url('customers/'.$customer->associated_hotel_id)}}" class="btn btn-warning">{{$dynamic->go_back}}</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection