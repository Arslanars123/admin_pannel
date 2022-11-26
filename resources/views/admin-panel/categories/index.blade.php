<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$dynamic->categories}}</a></li>
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
                            <a href="{{url('categories-create/'.$hotel_id)}}" style="padding: 10px;">{{$dynamic->createl}} +</a>
                            <table id="zero-config" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{$dynamic->name}} (English)</th>
                                        <th>{{$dynamic->name}} (Italian)</th>
                                        @if($hotel_id=="all")
                                        <th>{{$dynamic->hotel_name}}</th>
                                        @endif
                                        <th>{{$dynamic->image}}</th>
                                        <th>{{$dynamic->type}}</th>
                                        <th>{{$dynamic->products}}/{{$dynamic->services}}</th>
                                        <th class="no-content">{{$dynamic->actions}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($categories))
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{$category->name_en}}</td>
                                        <td>{{$category->name_it}}</td>
                                        @if($hotel_id=="all")
                                        <?php
                                            $hotel=\App\Models\Account::find($category->hotel_id)->first();
                                         ?>
                                        <td>{{$hotel->name}}</td> 
                                        @endif
                                        <td><img src="{{asset($category->image)}}" style="width: 30px"></td>
                                        <td>{{$category->type}}</td>
                                        @if($category->type=="product")
                                            <td><a href="{{url('products/'.$category->id)}}" class="btn btn-sm btn-primary">{{$dynamic->products}}</a></td>
                                        @endif
                                        @if($category->type=="service")
                                            <td><a href="{{url('services/'.$category->id)}}" class="btn btn-sm btn-secondary">{{$dynamic->services}}</a></td>
                                        @endif
                                        <td><div class="icon-container">
                                            <a href="{{url('categories-edit/'.$category->id)}}"><i data-feather="edit"></i><span class="icon-name"> {{$dynamic->editl}}</span></a>
                                            <a href="{{url('categories-delete/'.$category->id)}}">
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
                                        @if($hotel_id=="all")
                                        <th>{{$dynamic->hotel_name}}</th>
                                        @endif
                                        <th>{{$dynamic->image}}</th>
                                        <th>{{$dynamic->type}}</th>
                                        <th>{{$dynamic->products}}/{{$dynamic->services}}</th>
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