<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$dynamic->customers}}</a></li>
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
                            <a href="{{url('customers-create/'.$hotel_id)}}" style="padding: 10px;">{{$dynamic->createl}} +</a>
                            <table id="zero-config" class="table table-striped" style="width:100%">
                                <thead>
                                    <?php 
                                        $fields=\App\Models\CustomerField::all();
                                    ?>
                                    <tr>
                                        <th>{{$dynamic->name}}</th>
                                        @if($hotel_id=="all")
                                        <th>{{$dynamic->hotel_name}}</th>
                                        @endif
                                         <th>{{$dynamic->reservation_code}}</th>
                                        <th>{{$dynamic->email}}</th>
                                        <th>{{$dynamic->password}}</th>
                                        <th>{{$dynamic->phone}}</th>
                                        <th>{{$dynamic->adults}}</th>
                                        <th>{{$dynamic->children}}</th>
                                        <th>Date From</th>
                                        <th>Date To</th>
                                        <th>{{$dynamic->image}}</th>
                                        <th>ID Image</th>
                                        @foreach($fields as $field)
                                        @if($field->field_type=="string")
                                        <th>{{$field->english_label}}</th>
                                        <th>{{$field->italian_label}}</th>
                                        @endif
                                        @if($field->field_type!="string")
                                        <th>{{$field->english_label}} / {{$field->italian_label}}</th>
                                        @endif
                                        @endforeach
                                        <th class="no-content">{{$dynamic->bookings}}</th>
                                        <th class="no-content">{{$dynamic->reservations}}</th>
                                        <th class="no-content">{{$dynamic->summary}}</th>
                                        
                                        <th class="no-content">{{$dynamic->actions}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($customers))
                                    @foreach($customers as $customer)
                                    <tr>
                                        <td>{{$customer->name}}</td>
                                        @if($hotel_id=="all")
                                        <?php
                                            $hotel=\App\Models\Account::find($customer->associated_hotel_id)->first();
                                         ?>
                                        <td>{{$hotel->name}}</td> 
                                        @endif
                                        <td>{{$customer->reservation_code}}</td>
                                        <td>{{$customer->email}}</td>
                                        <td>{{$customer->password}}</td>
                                        <td>{{$customer->phone}}</td>
                                        <td>{{$customer->adults}}</td>
                                        <td>{{$customer->children}}</td>
                                        <td>{{$customer->dateFrom}}</td>
                                        <td>{{$customer->dateTo}}</td>
                                        <td><img src="{{asset($customer->image)}}" style="width: 30px"></td>
                                        <td><img src="{{asset($customer->id_image)}}" style="width: 30px"></td>
                                        @foreach($fields as $field)
                                        @if($field->field_type=="string")
                                        <?php
                                            $nam_en=$field->field_name."_en";
                                            $nam_it=$field->field_name."_it";
                                         ?>
                                        <td>{{$customer[$nam_en]}}</td>
                                        <td>{{$customer[$nam_it]}}</td>
                                        @endif
                                        @if($field->field_type!="string")
                                        <td>{{$customer[$field->field_name]}}</td>
                                        @endif
                                        @endforeach
                                        <td><a href="{{url('bookings/'.$customer->id)}}" class="btn btn-primary">Bookings</a></td>
                                        <td><a href="{{url('reserves/'.$customer->id)}}" class="btn btn-secondary">{{$dynamic->reservations}}</a></td>
                                        <td><a href="{{url('get-summary/'.$customer->id)}}" class="btn btn-secondary">{{$dynamic->summary}}</a></td>
                                        <td><div class="icon-container">
                                            <a href="{{url('customers-edit/'.$customer->id)}}"><i data-feather="edit"></i><span class="icon-name"> {{$dynamic->editl}}</span></a>
                                            <a href="{{url('customers-delete/'.$customer->id)}}">
                                            <i data-feather="trash"></i><span class="icon-name"> {{$dynamic->deletel}}</span></a>
                                        </div></td>

                                    </tr>
                                    @endforeach
                                    @endif
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{$dynamic->name}}</th>
                                        @if($hotel_id=="all")
                                        <th>{{$dynamic->hotel_name}}</th>
                                        @endif
                                         <th>{{$dynamic->reservation_code}}</th>
                                        <th>{{$dynamic->email}}</th>
                                        <th>{{$dynamic->password}}</th>
                                        <th>{{$dynamic->phone}}</th>
                                        <th>{{$dynamic->adults}}</th>
                                        <th>{{$dynamic->children}}</th>
                                        <th>{{$dynamic->image}}</th>
                                        <th>ID Image</th>
                                        @foreach($fields as $field)
                                        @if($field->field_type=="string")
                                        <th>{{$field->english_label}}</th>
                                        <th>{{$field->italian_label}}</th>
                                        @endif
                                        @if($field->field_type!="string")
                                        <th>{{$field->english_label}} / {{$field->italian_label}}</th>
                                        @endif
                                        @endforeach
                                        <th class="no-content">{{$dynamic->bookings}}</th>
                                        <th class="no-content">{{$dynamic->reservations}}</th>
                                        <th class="no-content">{{$dynamic->summary}}</th>
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