<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$dynamic->customers}}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>{{$dynamic->reservations}}</span></li>
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
                            <table id="zero-config" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{$dynamic->customer_name}}</th>
                                        <th>{{$dynamic->service_name}}</th>
                                        <th>{{$dynamic->price}}</th>
                                        <th>{{$dynamic->reserve_date}}</th>
                                        <th>{{$dynamic->event_date}}</th>
                                        <th>{{$dynamic->number_of_people}}</th>
                                        <th>{{$dynamic->number_of_children}}</th>
                                        <th>{{$dynamic->hours_from}}</th>
                                        <th>{{$dynamic->hours_to}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($reserves))
                                    @foreach($reserves as $reserve)
                                    <tr>
                                        <?php
                                            $user=\App\Models\User::find($reserve->user_id);
                                            $service=\App\Models\ServiceInfo::find($reserve->service_id);
                                         ?>
                                        <td>{{$user->name}}</td>
                                        <td>{{$service->name_en}} / {{$service->name_it}}</td>
                                        <td>{{$service->price}}</td>
                                        <td>{{$reserve->reserve_date}}</td>
                                        <td>{{$reserve->event_date}}</td>
                                        <td>{{$reserve->number_of_people}}</td>
                                        <td>{{$reserve->number_of_children}}</td>
                                        <td>{{$reserve->hours_from}}</td>
                                        <td>{{$reserve->hours_to}}</td>

                                    </tr>
                                    @endforeach
                                    @endif
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{$dynamic->customer_name}}</th>
                                        <th>{{$dynamic->service_name}}</th>
                                        <th>{{$dynamic->price}}</th>
                                        <th>{{$dynamic->reserve_date}}</th>
                                        <th>{{$dynamic->event_date}}</th>
                                        <th>{{$dynamic->number_of_people}}</th>
                                        <th>{{$dynamic->number_of_children}}</th>
                                        <th>{{$dynamic->hours_from}}</th>
                                        <th>{{$dynamic->hours_to}}</th>
                                        
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