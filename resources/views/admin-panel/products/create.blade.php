<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$dynamic->products}}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>{{$dynamic->createl}}</span></li>
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
                                        <h4>Create Product</h4>
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
                                <form style="padding: 5%;" method="POST" action="{{url('products-store')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Name (English)</label>
                                        <input type="text" name="name_en" class="form-control" id="formGroupExampleInput" placeholder="" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Name (Italian)</label>
                                        <input type="text" name="name_it" class="form-control" id="formGroupExampleInput" placeholder="" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$dynamic->price}}</label>
                                        <input type="text" name="price" class="form-control" id="formGroupExampleInput" placeholder="" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$dynamic->image}}</label>
                                        <input type="file" name="image" class="form-control" id="formGroupExampleInput" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Multiple Images</label>
                                        <input type="file" name="images[]" class="form-control" id="formGroupExampleInput" multiple="multiple">
                                    </div>
                                    <?php
                                        $fields=\App\Models\ProductField::all();
                                     ?>
                                     @foreach($fields as $field)
                                     @if($field->field_type=="string")
                                     <?php
                                        $nam_en=$field->field_name."_en";
                                        $nam_it=$field->field_name."_it";
                                      ?>
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}}</label>
                                        <input type="text" name="{{$nam_en}}" class="form-control" id="formGroupExampleInput" placeholder="" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->italian_label}}</label>
                                        <input type="text" name="{{$nam_it}}" class="form-control" id="formGroupExampleInput" placeholder="" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif

                                     @if($field->field_type=="description")
                                     <?php
                                        $nam_en=$field->field_name."_en";
                                        $nam_it=$field->field_name."_it";
                                        
                                      ?>
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}}</label>
                                        <textarea id="demo1" name="{{$nam_en}}" @if($field->is_mandatory=="Yes") required="required" @endif ></textarea>
                                        
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->italian_label}}</label>
                                        <textarea id="demo2" name="{{$nam_it}}" @if($field->is_mandatory=="Yes") required="required" @endif ></textarea>
                                    </div>
                                     @endif

                                     @if($field->field_type=="integer")
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}} / {{$field->italian_label}}</label>
                                        <input type="number" name="{{$field->field_name}}" class="form-control" id="formGroupExampleInput" placeholder="" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif

                                     @if($field->field_type=="date")
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}} / {{$field->italian_label}}</label>
                                        <input type="date" name="{{$field->field_name}}" class="form-control" id="formGroupExampleInput" placeholder="" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif

                                     @if($field->field_type=="time")
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}} / {{$field->italian_label}}</label>
                                        <input type="time" name="{{$field->field_name}}" class="form-control" id="formGroupExampleInput" placeholder="Enter {{$field->english_label}}" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif

                                     @if($field->field_type=="dropdown")
                                     <?php
                                        $items=\App\Models\Dropdown::where('table_name','productsinformations')->where('column_name',$field->field_name)->get();
                                      ?>
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}} / {{$field->italian_label}}</label>
                                        <select name="{{$field->field_name}}" class="form-control" @if($field->is_mandatory=="Yes") required="required" @endif >
                                            @if(!empty($items))
                                            <option value="">Choose here</option>
                                            @foreach($items as $item)
                                            <option value="{{$item->item_name}}">{{$item->item_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                     @endif

                                     @if($field->field_type=="file")
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}} / {{$field->italian_label}}</label>
                                        <input type="file" name="{{$field->field_name}}" class="form-control" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif
                                     @endforeach
                                    <input type="hidden" name="catId" value="{{$catId}}">
                                    <!--<input type="submit" value="Store" class="btn btn-primary">-->
                                    <button name="sav" class="btn btn-primary" value="SAVE AND EXIT" type="submit">{{$dynamic->save_exit}}</button>
                                    <button name="sav" class="btn btn-secondary" value="SAVE AND STAY" type="submit">{{$dynamic->save_stay}}</button>
                                    <a href="{{url('products/'.$catId)}}" class="btn btn-warning">{{$dynamic->go_back}}</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection