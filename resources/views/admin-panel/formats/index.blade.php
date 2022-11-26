<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$dynamic->email_templates}}</a></li>
            <!--<li class="breadcrumb-item active" aria-current="page"><span>Striped</span></li>
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
                            <a href="{{url('formats-create')}}" style="padding: 10px;">{{$dynamic->createl}} +</a>
                            <table id="zero-config" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{$dynamic->title}}</th>
                                        <th class="no-content">{{$dynamic->actions}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(!empty($formats))
                                    @foreach($formats as $format)
                                    <tr>
                                        <td>{{$format->title}}</td>
                                        @if(Auth::user()->role=="hotel-manager"&&$format->associated_hotel_id==Auth::user()->associated_hotel_id)

                                        <td><div class="icon-container">
                                            <a href="{{url('formats-edit/'.$format->id)}}"><i data-feather="edit"></i><span class="icon-name"> {{$dynamic->edit}}</span></a>
                                            <a href="{{url('formats-delete/'.$format->id)}}">
                                            <i data-feather="trash"></i><span class="icon-name"> {{$dynamic->delete}}</span></a>
                                        </div></td>
                                        @endif
                                        @if(Auth::user()->role=="super-admin")
                                        <td><div class="icon-container">
                                            <a href="{{url('formats-edit/'.$format->id)}}"><i data-feather="edit"></i><span class="icon-name"> {{$dynamic->editl}}</span></a>
                                            <a href="{{url('formats-delete/'.$format->id)}}">
                                            <i data-feather="trash"></i><span class="icon-name"> {{$dynamic->deletel}}</span></a>
                                        </div></td>
                                        @endif

                                    </tr>
                                    @endforeach
                                    @endif
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{$dynamic->title}}</th>
                                        
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