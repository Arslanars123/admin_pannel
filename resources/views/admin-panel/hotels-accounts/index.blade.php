<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">{{$dynamic->hotels_accounts}}</a></li>
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
                            <a href="{{url('hotels-accounts-create')}}" style="padding: 10px;">{{$dynamic->createl}} +</a>
                            <table id="zero-config" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{$dynamic->name}}</th>
                                        <th>{{$dynamic->email}}</th>
                                        <th>{{$dynamic->password}}</th>
                                        <th>Terms & Conditions</th>
                                        <th>{{$dynamic->hotel_information}}</th>
                                        <th>{{$dynamic->customers}}</th>
                                        <th>{{$dynamic->categories}}</th>
                                        <th>{{$dynamic->ratings}}</th>
                                        <th>{{$dynamic->bookings}}</th>
                                        <th>{{$dynamic->services_reservations}}</th>
                                        <th>{{$dynamic->services_reservations_calender}}</th>
                                        <th class="no-content">{{$dynamic->actions}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($accounts))
                                    @foreach($accounts as $account)
                                    <tr>
                                        <td>{{$account->name}}</td>
                                        <td>{{$account->email}}</td>
                                        <td>{{$account->password}}</td>
                                        <td><a href="{{url('conditions/'.$account->id)}}" class="btn btn-sm btn-primary">Terms & Conditions</a></td>
                    
                                        <td><a href="{{url('informations/'.$account->id)}}" class="btn btn-sm btn-primary">{{$dynamic->hotel_information}}</a></td>
                                        <td><a href="{{url('customers/'.$account->id)}}" class="btn btn-sm btn-secondary">{{$dynamic->customers}}</a></td>
                                        <td><a href="{{url('categories/'.$account->id)}}" class="btn btn-sm btn-success">{{$dynamic->categories}}</a></td>
                                        <td><a href="{{url('ratings/'.$account->id)}}" class="btn btn-sm btn-warning">{{$dynamic->ratings}}</a></td>
                                        <td><a href="{{url('bookings-of-hotel/'.$account->id)}}" class="btn btn-sm btn-primary">{{$dynamic->bookings}}</a></td>
                                        <td><a href="{{url('reserves-of-hotel/'.$account->id)}}" class="btn btn-sm btn-primary">{{$dynamic->services_reservations}}</a></td>
                                        <td><a href="{{url('reserves-in-calender/'.$account->id)}}" class="btn btn-sm btn-desfault">{{$dynamic->services_reservations_calender}}</a></td>
                                        <td><div class="icon-container">
                                            <a href="{{url('hotels-accounts-edit/'.$account->id)}}"><i data-feather="edit"></i><span class="icon-name"> {{$dynamic->editl}}</span></a>
                                            <a href="{{url('hotels-accounts-delete/'.$account->id)}}">
                                            <i data-feather="trash"></i><span class="icon-name"> {{$dynamic->deletel}}</span></a>
                                        </div></td>

                                    </tr>
                                    @endforeach
                                    @endif
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{$dynamic->name}}</th>
                                        <th>{{$dynamic->email}}</th>
                                        <th>{{$dynamic->password}}</th>
                                        <th>{{$dynamic->hotel_information}}</th>
                                        <th>{{$dynamic->customers}}</th>
                                        <th>{{$dynamic->categories}}</th>
                                        <th>{{$dynamic->ratings}}</th>
                                        <th>{{$dynamic->bookings}}</th>
                                        <th>{{$dynamic->services_reservations}}</th>
                                        <th>{{$dynamic->services_reservations_calender}}</th>
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