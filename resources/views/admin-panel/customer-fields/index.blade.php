<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
@extends('admin-panel.main')
@section('breadcrum')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$dynamic->customers_fields}}</a></li>
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
                            <a href="{{url('customer-fields-create')}}" style="padding: 10px;">{{$dynamic->createl}} +</a>
                            <table id="zero-config" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{$dynamic->english_label}}</th>
                                        <th>{{$dynamic->italian_label}}</th>
                                        <th>{{$dynamic->field_type}}</th>
                                        <th>{{$dynamic->is_mandatory}}</th>
                                        <th>{{$dynamic->order_no}}</th>
                                        
                                        <th class="no-content">{{$dynamic->actions}}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>Name</td>
                                        <td>Nome</td>
                                        <td>Predefined / Fixed</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>E-mail</td>
                                        <td>Predefined / Fixed</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Password</td>
                                        <td>Parola d'ordine</td>
                                        <td>Predefined / Fixed</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>Telefono</td>
                                        <td>Predefined / Fixed</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Image</td>
                                        <td>Immagine</td>
                                        <td>Predefined / Fixed</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    
                                    @if(!empty($customerfields))
                                    @foreach($customerfields as $customerfield)
                                    <tr>
                                        <td>{{$customerfield->english_label}}</td>
                                        <td>{{$customerfield->italian_label}}</td>
                                        <td>{{$customerfield->field_type}}</td>
                                        <td>{{$customerfield->is_mandatory}}</td>
                                        <td>{{$customerfield->orderNo}}</td>
                                        <td><div class="icon-container">
                                            <a href="{{url('customer-fields-edit/'.$customerfield->id)}}"><i data-feather="edit"></i><span class="icon-name"> {{$dynamic->editl}}</span></a>
                                            <a href="{{url('customer-fields-delete/'.$customerfield->id)}}">
                                            <i data-feather="trash"></i><span class="icon-name"> {{$dynamic->deletel}}</span></a>
                                        </div></td>

                                    </tr>
                                    @endforeach
                                    @endif
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{$dynamic->english_label}}</th>
                                        <th>{{$dynamic->italian_label}}</th>
                                        <th>{{$dynamic->field_type}}</th>
                                        <th>{{$dynamic->is_mandatory}}</th>
                                        <th>{{$dynamic->order_no}}</th>
                                        
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