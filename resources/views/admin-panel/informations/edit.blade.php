<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$dynamic->hotel_information}}</a></li>
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
                                        <h4>{{$dynamic->edit}} {{$dynamic->hotel_information}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form style="padding: 5%;" method="POST" action="{{url('informations-update/'.$information->id)}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Name (English)</label>
                                        <input type="text" name="name_en" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($information->name_en)){{$information->name_en}}@endif" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Name (Italian)</label>
                                        <input type="text" name="name_it" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($information->name_it)){{$information->name_it}}@endif" required="required">
                                    </div>
                                    
                                    @if(!empty($information->image))
                                    <img src="{{asset($information->image)}}" style="width: 70px;">
                                    @endif
                                    
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$dynamic->image}}</label>
                                        <input type="file" name="image" class="form-control" id="formGroupExampleInput">
                                    </div>

                                    @if(!empty($information->logo))
                                    <img src="{{asset($information->logo)}}" style="width: 70px;">
                                    @endif
                                    
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Logo</label>
                                        <input type="file" name="logo" class="form-control" id="formGroupExampleInput">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Show Name or Logo</label>
                                        <select class="form-control" name="showNameOrImage">
										
                                        @if($information->showNameOrImage==null)
                                        <option value="">Choose</option>
                                        <option value="name">Name</option>
                                        <option value="logo">Logo</option>
                                        @endif
                                        @if($information->showNameOrImage=="name")
                                        <option value="">Choose</option>
                                        <option value="name" selected>Name</option>
                                        <option value="logo">Logo</option>
                                        @endif
                                        @if($information->showNameOrImage=="logo")
                                        <option value="">Choose</option>
                                        <option value="name">Name</option>
                                        <option value="logo" selected>Logo</option>
                                        @endif
                                        </select>
                                    </div>
                                    <?php
                                        $fields=\App\Models\InfoField::all();
                                     ?>
                                     @foreach($fields as $field)
                                     @if($field->field_type=="string")
                                     <?php
                                        $nam_en=$field->field_name."_en";
                                        $nam_it=$field->field_name."_it";
                                        
                                      ?>
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}}</label>
                                        <input type="text" name="{{$nam_en}}" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($information[$nam_en])){{$information[$nam_en]}}@endif" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->italian_label}}</label>
                                        <input type="text" name="{{$nam_it}}" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($information[$nam_it])){{$information[$nam_it]}}@endif" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif
                                     @if($field->field_type=="description")
                                     <?php
                                        $nam_en=$field->field_name."_en";
                                        $nam_it=$field->field_name."_it";
                                        
                                      ?>
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}}</label>
                                        <textarea id="demo1" name="{{$nam_en}}" @if($field->is_mandatory=="Yes") required="required" @endif>@if(!empty($information[$nam_en])){{$information[$nam_en]}}@endif</textarea>
                                        
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->italian_label}}</label>
                                        <textarea id="demo2" name="{{$nam_it}}" @if($field->is_mandatory=="Yes") required="required" @endif >@if(!empty($information[$nam_it])){{$information[$nam_it]}}@endif</textarea>
                                        
                                    </div>
                                     @endif

                                     @if($field->field_type=="integer")
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}} / {{$field->italian_label}}</label>
                                        <input type="number" name="{{$field->field_name}}" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($information[$field->field_name])){{$information[$field->field_name]}}@endif" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif

                                     @if($field->field_type=="date")
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}}</label>
                                        <input type="date" name="{{$field->field_name}}" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($information[$field->field_name])){{$information[$field->field_name]}}@endif" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif

                                     @if($field->field_type=="time")
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}} / {{$field->italian_label}}</label>
                                        <input type="time" name="{{$field->field_name}}" class="form-control" id="formGroupExampleInput" placeholder="" value="@if(!empty($information[$field->field_name])){{$information[$field->field_name]}}@endif" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif

                                     @if($field->field_type=="dropdown")
                                     <?php
                                        $items=\App\Models\Dropdown::where('table_name','hotelsinformations')->where('column_name',$field->field_name)->get();
                                      ?>
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}} / {{$field->italian_label}}</label>
                                        <select name="{{$field->field_name}}" class="form-control"  @if($field->is_mandatory=="Yes") required="required" @endif >
                                            @if(!empty($items))
                                            <option value="">Choose here</option>
                                            @foreach($items as $item)
                                            <option value="{{$item->item_name}}" @if($information[$field->field_name]==$item->item_name) selected @endif>{{$item->item_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                     @endif
                                     @endforeach

                                     @if($field->field_type=="file")

                                     @if(!empty($information[$field->field_name]))
                                     <a href="{{asset($information[$field->field_name])}}" target="_blank">Download File</a>

                                     @endif
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$field->english_label}} / {{$field->italian_label}}</label>
                                        <input type="file" name="{{$field->field_name}}" class="form-control" @if($field->is_mandatory=="Yes") required="required" @endif >
                                    </div>
                                     @endif
                                    
                                    <input type="submit" value="Store" class="btn btn-primary">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection