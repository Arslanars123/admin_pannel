<?php
$dynamic=\App\Models\Dynamic::first();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{$dynamic->main_logo_title}} </title>
    <link rel="icon" type="image/x-icon" href="{{asset('admin-panel/assets/img/favicon.ico')}}"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{asset('admin-panel/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin-panel/assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin-panel/assets/css/authentication/form-2.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('admin-panel/assets/css/forms/theme-checkbox-radio.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-panel/assets/css/forms/switches.css')}}">
</head>
<body class="form">
    

    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">Password dimenticata</h1>
                        <p class=""></p>
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
                            <p>Abbiamo inviato un'email per reimpostare la password all'indirizzo di posta elettronica associato al tuo account, la sua effettiva visualizzazione in posta in Arrivo potrebbe richiedere alcuni minuti. Per favore attendi almeno 10 minuti prima di effettuare un'ulteriore richiesta.</p>
                       

                    </div>                    
                </div>
            </div>
        </div>
    </div>

    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{asset('admin-panel/assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('admin-panel/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('admin-panel/bootstrap/js/bootstrap.min.js')}}"></script>
    
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{asset('admin-panel/assets/js/authentication/form-2.js')}}"></script>

</body>
</html>