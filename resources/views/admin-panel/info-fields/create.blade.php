<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$dynamic->hotels_info_fields}}</a></li>
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
                                        <h4>{{$dynamic->hotels_info_fields}}</h4>
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
                                <form style="padding: 5%;" method="POST" action="{{url('info-fields-store')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$dynamic->english_label}}</label>
                                        <input type="text" name="english_label" class="form-control" id="formGroupExampleInput" placeholder="" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput2">{{$dynamic->italian_label}}</label>
                                        <input type="text" name="italian_label" class="form-control" id="formGroupExampleInput2" placeholder="" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput2">{{$dynamic->is_mandatory}}</label>
                                        <select name="is_mandatory" class="form-control" required="required">
                                            <option value="">Choose here</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput2">{{$dynamic->order_no}}</label>
                                        <input type="number" name="orderNo" class="form-control" id="formGroupExampleInput2" placeholder="" required="required">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput2">{{$dynamic->field_type}}</label>
                                        <select name="field_type" id="fty" class="form-control" required="required">
                                            <option value="">Choose here</option>
                                            <option value="string">String</option>
                                            <option value="integer">Numeric</option>
                                            <option value="date">Date</option>
                                            <option value="time">Time</option>
                                            <option value="dropdown">Dropdown</option>
                                            <option value="file">File</option>
                                            <option value="description">Description</option>
                                        </select>
                                    </div>
                                    <div style="display: none" id="dit">
                                    <label>{{$dynamic->dropdown_items}}</label>    
                                    <select class="form-control tagging" multiple="multiple" name="dropdown_items[]">
                                        
                                    </select>
                                    </div>
                                    <!--<input type="submit" value="Store" class="btn btn-primary">-->
                                    <button name="sav" class="btn btn-primary" value="SAVE AND EXIT" type="submit">{{$dynamic->save_exit}}</button>
                                    <button name="sav" class="btn btn-secondary" value="SAVE AND STAY" type="submit">{{$dynamic->save_stay}}</button>
                                    <a href="{{url('info-fields')}}" class="btn btn-warning">{{$dynamic->go_back}}</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection