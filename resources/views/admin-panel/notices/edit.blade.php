<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Notice</a></li>
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
                                        <h4>{{$dynamic->editl}} Notice</h4>
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
                                <form style="padding: 5%;" method="POST" action="{{url('notices-update/'.$notice->id)}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    
                                     <div class="form-group mb-4">
                                        <label for="formGroupExampleInput">Notice</label>
                                        <textarea id="demo1" name="notice">@if(!empty($notice)){{$notice->notice}}@endif</textarea>   
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