<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$dynamic->categories}}</a></li>
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
                                        <h4>{{$dynamic->create}} {{$dynamic->categories}}</h4>
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
                                <form style="padding: 5%;" method="POST" action="{{url('categories-store')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$dynamic->name}} (English)</label>
                                        <input type="text" name="name_en" class="form-control" id="formGroupExampleInput" placeholder="">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$dynamic->categories}} (Italian)</label>
                                        <input type="text" name="name_it" class="form-control" id="formGroupExampleInput" placeholder="">
                                    </div>
                                    <label>{{$dynamic->type}}</label>
                                    <select name="type" class="form-control">
                                        <option value="">Choose here</option>
                                        <option value="product">Product</option>
                                        <option value="service">Service</option>
                                    </select>

                                    <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">{{$dynamic->image}}</label>
                                        <input type="file" name="image" class="form-control" id="formGroupExampleInput">
                                    </div>

                                    <input type="hidden" name="hotel_id" value="{{$hotel_id}}">
                                    <!--<input type="submit" value="SAVE AND EXIT" name="sav" class="btn btn-primary">
                                    <input type="submit" value="SAVE AND STAY" name="sav" class="btn btn-secondary">
                                    <input type="submit" value="GO BACK WITHOUT SAVING" name="sav" class="btn btn-warning">-->
                                    <button name="sav" class="btn btn-primary" value="SAVE AND EXIT" type="submit">{{$dynamic->save_exit}}</button>
                                    <button name="sav" class="btn btn-secondary" value="SAVE AND STAY" type="submit">{{$dynamic->save_stay}}</button>
                                    <a href="{{url('categories/'.$hotel_id)}}" class="btn btn-warning">{{$dynamic->go_back}}</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection