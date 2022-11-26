<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$dynamic->services}}</a></li>
            <!--<li class="breadcrumb-item active" aria-current="page"><span>Striped</span></li>-->
        </ol>
    </nav>
@endsection
@section('content')
<!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing" id="cancel-row">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
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
                            <a href="{{url('services-create/'.$catId)}}" style="padding: 10px;">{{$dynamic->createl}} +</a>
                            <table id="zero-config" class="table table-striped" style="width:100%">
                                <thead>
                                    <?php 
                                        $fields=\App\Models\ServiceField::all();
                                    ?>
                                    <tr>
                                        <th>{{$dynamic->name}} (English)</th>
                                        <th>{{$dynamic->name}} (Italian)</th>
                                        <th>{{$dynamic->price}}</th>
                                        <th>{{$dynamic->image}}</th>
                                        @foreach($fields as $field)
                                        @if($field->field_type=="string")
                                        <th>{{$field->english_label}}</th>
                                        <th>{{$field->italian_label}}</th>
                                        @endif
                                        @if($field->field_type!="string")
                                        <th>{{$field->english_label}} / {{$field->italian_label}}</th>
                                        @endif
                                        @endforeach
                                        
                                        <th class="no-content">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($services))
                                    @foreach($services as $service)
                                    <tr>
                                        <td>{{$service->name_en}}</td>
                                        <td>{{$service->name_it}}</td>
                                        <td>{{$service->price}}</td>
                                        <td><img src="{{asset($service->image)}}" style="width: 30px"></td>
                                        @foreach($fields as $field)
                                        @if($field->field_type=="string")
                                        <?php
                                            $nam_en=$field->field_name."_en";
                                            $nam_it=$field->field_name."_it";
                                         ?>
                                        <td>{{$service[$nam_en]}}</td>
                                        <td>{{$service[$nam_it]}}</td>
                                        @endif
                                        @if($field->field_type!="string")
                                        <td>{{$service[$field->field_name]}}</td>
                                        @endif
                                        @endforeach
                                        <td><div class="icon-container">
                                            <a href="{{url('services-edit/'.$service->id)}}"><i data-feather="edit"></i><span class="icon-name"> {{$dynamic->editl}}</span></a>
                                            <a href="{{url('services-delete/'.$service->id)}}">
                                            <i data-feather="trash"></i><span class="icon-name"> {{$dynamic->deletel}}</span></a>
                                        </div></td>

                                    </tr>
                                    @endforeach
                                    @endif
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{$dynamic->name}} (English)</th>
                                        <th>{{$dynamic->name}} (Italian)</th>
                                        <th>{{$dynamic->price}}</th>
                                        <th>{{$dynamic->image}}</th>
                                        @foreach($fields as $field)
                                        @if($field->field_type=="string")
                                        <th>{{$field->english_label}}</th>
                                        <th>{{$field->italian_label}}</th>
                                        @endif
                                        @if($field->field_type!="string")
                                        <th>{{$field->english_label}} / {{$field->italian_label}}</th>
                                        @endif
                                        @endforeach
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!--  END CONTENT PART  -->
@endsection