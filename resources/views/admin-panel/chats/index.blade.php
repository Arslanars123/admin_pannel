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
    
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{asset('admin-panel/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin-panel/assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{asset('admin-panel/assets/css/apps/mailing-chat.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    
</head>
<body>
    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="{{url('/')}}">
                        @if(Auth::user()->role=="super-admin")
                        <img src="{{asset($dynamic->main_logo)}}" class="navbar-logo" alt="logo">
                        @endif

                        @if(Auth::user()->role=="hotel-manager")
                        <?php
                            $hotel=\App\Models\Account::find(Auth::user()->associated_hotel_id);
                            $hotelInfo=\App\Models\HotelInfo::find($hotel->id);
                         ?>
                        <!--<img src="{{asset($hotelInfo->image)}}" class="navbar-logo" alt="logo">-->
                        <img src="{{asset($dynamic->main_logo)}}" class="navbar-logo" alt="logo">
                        @endif
                    </a>
                </li>
                <li class="nav-item theme-text">
                    @if(Auth::user()->role=="super-admin")
                    
                    <a href="{{url('/')}}" class="nav-link"> {{$dynamic->main_logo_title}} </a>
                    @endif
                    @if(Auth::user()->role=="hotel-manager")
                    <?php
                        $hotel=\App\Models\Account::find(Auth::user()->associated_hotel_id);
                        $hotelInfo=\App\Models\HotelInfo::find($hotel->id);
                     ?>
                     <a href="{{url('/')}}" class="nav-link"> {{$dynamic->main_logo_title}} / {{$hotel->name}}</a>
                    
                    @endif
                </li>
            </ul>

            <!--<ul class="navbar-item flex-row ml-md-0 ml-auto">
                <li class="nav-item align-self-center search-animated">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <form class="form-inline search-full form-inline search" role="search">
                        <div class="search-bar">
                            <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">
                        </div>
                    </form>
                </li>
            </ul>-->

            <ul class="navbar-item flex-row ml-md-auto">

                <!--<li class="nav-item dropdown language-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="language-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{asset('admin-panel/assets/img/ca.png')}}" class="flag-width" alt="flag">
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">
                        <a class="dropdown-item d-flex" href="javascript:void(0);"><img src="{{asset('admin-panel/assets/img/de.png')}}" class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;German</span></a>
                        <a class="dropdown-item d-flex" href="javascript:void(0);"><img src="{{asset('admin-panel/assets/img/jp.png')}}" class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;Japanese</span></a>
                        <a class="dropdown-item d-flex" href="javascript:void(0);"><img src="{{asset('admin-panel/assets/img/fr.png')}}" class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;French</span></a>
                        <a class="dropdown-item d-flex" href="javascript:void(0);"><img src="{{asset('admin-panel/assets/img/ca.png')}}" class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;English</span></a>
                    </div>
                </li>

                <li class="nav-item dropdown message-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="messageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="messageDropdown">
                        <div class="">
                            <a class="dropdown-item">
                                <div class="">

                                    <div class="media">
                                        <div class="user-img">
                                            <div class="avatar avatar-xl">
                                                <span class="avatar-title rounded-circle">KY</span>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="">
                                                <h5 class="usr-name">Kara Young</h5>
                                                <p class="msg-title">ACCOUNT UPDATE</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </a>
                            <a class="dropdown-item">
                                <div class="">
                                    <div class="media">
                                        <div class="user-img">
                                            <img src="{{asset('admin-panel/assets/img/90x90.jpg')}}" class="img-fluid mr-2" alt="avatar">
                                        </div>
                                        <div class="media-body">
                                            <div class="">
                                                <h5 class="usr-name">Daisy Anderson</h5>
                                                <p class="msg-title">ACCOUNT UPDATE</p>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </a>
                            <a class="dropdown-item">
                                <div class="">

                                    <div class="media">
                                        <div class="user-img">
                                            <div class="avatar avatar-xl">
                                                <span class="avatar-title rounded-circle">OG</span>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="">
                                                <h5 class="usr-name">Oscar Garner</h5>
                                                <p class="msg-title">ACCOUNT UPDATE</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </a>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class="badge badge-success"></span>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                        <div class="notification-scroll">

                            <div class="dropdown-item">
                                <div class="media server-log">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6" y2="6"></line><line x1="6" y1="18" x2="6" y2="18"></line></svg>
                                    <div class="media-body">
                                        <div class="data-info">
                                            <h6 class="">Server Rebooted</h6>
                                            <p class="">45 min ago</p>
                                        </div>

                                        <div class="icon-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-item">
                                <div class="media ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                    <div class="media-body">
                                        <div class="data-info">
                                            <h6 class="">Licence Expiring Soon</h6>
                                            <p class="">8 hrs ago</p>
                                        </div>

                                        <div class="icon-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-item">
                                <div class="media file-upload">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                    <div class="media-body">
                                        <div class="data-info">
                                            <h6 class="">Kelly Portfolio.pdf</h6>
                                            <p class="">670 kb</p>
                                        </div>

                                        <div class="icon-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>-->

                <li class="nav-item dropdown user-profile-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <!--<img src="{{asset('admin-panel/assets/img/90x90.jpg')}}" alt="avatar">-->
                        @if(Auth::user()->role=="super-admin")
                        <img src="{{asset($dynamic->main_logo)}}" class="navbar-logo" alt="avatar">
                        @endif

                        @if(Auth::user()->role=="hotel-manager")
                        <?php
                            $hotel=\App\Models\Account::find(Auth::user()->associated_hotel_id);
                            $hotelInfo=\App\Models\HotelInfo::find($hotel->id);
                         ?>
                         @if(!empty($hotelInfo->image))
                        <img src="{{asset($hotelInfo->image)}}" class="navbar-logo" alt="avatar">
                        @endif
                        @endif
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="">
                            <!--<div class="dropdown-item">
                                <a class="" href="user_profile.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Profile</a>
                            </div>
                            <div class="dropdown-item">
                                <a class="" href="apps_mailbox.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg> Inbox</a>
                            </div>
                            <div class="dropdown-item">
                                <a class="" href="auth_lockscreen.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> Lock Screen</a>
                            </div>-->
                            <div class="dropdown-item">
                                @if(Auth::user()->role=="super-admin")
                                <a href="{{url('dynamics')}}">{{$dynamic->labels}}</a>
                                @endif
                                <a href="{{url('change-my-password')}}">Cambia la password</a>
                                <a class="" href="{{url('logout')}}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> {{$dynamic->signout}}</a>
                            </div>
                        </div>
                    </div>
                </li>
                </li>

            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN NAVBAR  -->
    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">

                        @yield('breadcrum')
                        <!--<nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">DataTables</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>Striped</span></li>
                            </ol>
                        </nav>-->

                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">
            
            <nav id="sidebar">
                <div class="shadow-bottom"></div>

                <ul class="list-unstyled menu-categories" id="accordionExample">
                    @if(Auth::user()->role=="super-admin")
                    <li class="menu">
                        <a href="{{url('hotels-accounts')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->hotels_accounts}}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('info-fields')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->hotels_info_fields}}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('customer-fields')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->customers_fields}}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('product-fields')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->products_fields}}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('service-fields')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->services_fields}}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('dynamics')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>Labels</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('customers/'.Auth::user()->associated_hotel_id)}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->customers}}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('categories/'.Auth::user()->associated_hotel_id)}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->categories}}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('change-my-password')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>Change Password</span>
                            </div>
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->role=="hotel-manager")
                    <li class="menu">
                        <a href="{{url('customers/'.Auth::user()->associated_hotel_id)}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->customers}}</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="{{url('categories/'.Auth::user()->associated_hotel_id)}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->categories}}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('informations/'.Auth::user()->associated_hotel_id)}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->hotel_information}}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('ratings/'.Auth::user()->associated_hotel_id)}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->ratings}}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('chat')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->chat}}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('bookings-of-hotel/'.Auth::user()->associated_hotel_id)}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->bookings}}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('reserves-of-hotel/'.Auth::user()->associated_hotel_id)}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->services_reservations}}</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="{{url('reserves-in-calender/'.Auth::user()->associated_hotel_id)}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>{{$dynamic->services_reservations_calender}}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('formats')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>Email Template</span>
                            </div>
                        </a>
                    </li>
                    
                    <li class="menu">
                        <a href="{{url('email-customers')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>Send Email<br>To (Customers)</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="{{url('change-my-password')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>Change Password</span>
                            </div>
                        </a>
                    </li>

                    @endif
                    <!--<li class="menu">
                        <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Dashboard</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="dashboard" data-parent="#accordionExample">
                            <li>
                                <a href="index.html"> Sales </a>
                            </li>
                            <li>
                                <a href="index2.html"> Analytics </a>
                            </li>
                        </ul>
                    </li>-->
                    <!--<li class="menu">
                        <a href="table_basic.html" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>Tables</span>
                            </div>
                        </a>
                    </li>-->
                    <!--<li class="menu">
                        <a href="#app" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                                <span>Apps</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="app" data-parent="#accordionExample">
                            <li>
                                <a href="apps_chat.html"> Chat </a>
                            </li>
                            <li>
                                <a href="apps_mailbox.html"> Mailbox  </a>
                            </li>
                            <li>
                                <a href="apps_todoList.html"> Todo List </a>
                            </li>                            
                            <li>
                                <a href="apps_notes.html"> Notes </a>
                            </li>
                            <li>
                                <a href="apps_scrumboard.html">Scrumboard</a>
                            </li>
                            <li>
                                <a href="apps_contacts.html"> Contacts </a>
                            </li>
                            <li>
                                <a href="#appInvoice" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> Invoice <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="collapse list-unstyled sub-submenu" id="appInvoice" data-parent="#app"> 
                                    <li>
                                        <a href="apps_invoice-list.html"> List </a>
                                    </li>
                                    <li>
                                        <a href="apps_invoice-preview.html"> Preview </a>
                                    </li>
                                    <li>
                                        <a href="apps_invoice-add.html"> Add </a>
                                    </li>
                                    <li>
                                        <a href="apps_invoice-edit.html"> Edit </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="apps_calendar.html"> Calendar </a>
                            </li>
                        </ul>
                    </li>-->

                    
                    
                </ul>
                
            </nav>

        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="chat-section layout-top-spacing">
                    <div class="row">

                        <div class="col-xl-12 col-lg-12 col-md-12">

                            <div class="chat-system">
                                <div class="hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu mail-menu d-lg-none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></div>
                                <div class="user-list-box">
                                    <div class="search">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                        <input type="text" class="form-control" placeholder="Search" />
                                    </div>
                                    <div class="people">
                                        <?php
                                            $customers=\App\Models\Chat::where('hotel_id',Auth::user()->associated_hotel_id)->select('customer_id')->distinct()->get();
                                        //dd(Auth::user()->associated_hotel_id);
                                         ?>

                                        
                                        @foreach($customers as $customerId)
                                        <?php
                                            $customer=\App\Models\User::find($customerId->customer_id);
                                            $lastMessage=\App\Models\Chat::where('hotel_id',Auth::user()->associated_hotel_id)->where('customer_id',$customer->id)->orderBy('created_at','desc')->first();
                                         ?>
                                        <div class="person" data-chat="person{{$customer->id}}" id="person{{$customer->id}}">
                                            <div class="user-info">
                                                <div class="f-head">
                                                    <img src="{{asset('admin-panel/assets/img/90x90.jpg')}}" alt="avatar">
                                                </div>
                                                <div class="f-body">
                                                    <div class="meta-info">
                                                        <span class="user-name" data-name="{{$customer->name}}">{{$customer->name}}</span>
                                                        <span class="user-meta-time">{{$lastMessage->created_at}}</span>
                                                    </div>
                                                    <?php
                                                        $ex=\App\Models\Chat::where('hotel_id',Auth::user()->associated_hotel_id)->where('sender','customer')->where('read','no')->exists();
                                                     ?>
                                                     @if($ex==true)
                                                    <span class="preview" id="{{$customer->name}}">New</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                        <!--<div class="person" data-chat="person2">
                                            <div class="user-info">
                                                <div class="f-head">
                                                    <img src="{{asset('admin-panel/assets/img/90x90.jpg')}}" alt="avatar">
                                                </div>
                                                <div class="f-body">
                                                    <div class="meta-info">
                                                        <span class="user-name" data-name="Alma Clarke">Alma Clarke</span>
                                                        <span class="user-meta-time">1:44 PM</span>
                                                    </div>
                                                    <span class="preview">I've forgotten how it felt before</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="person" data-chat="person3">
                                            <div class="user-info">
                                                <div class="f-head">
                                                    <img src="{{asset('admin-panel/assets/img/90x90.jpg')}}" alt="avatar">
                                                </div>
                                                <div class="f-body">
                                                    <div class="meta-info">
                                                        <span class="user-name" data-name="Alan Green">Alan Green</span>
                                                        <span class="user-meta-time">2:09 PM</span>
                                                    </div>
                                                    <span class="preview">But we’re probably gonna need a new carpet.</span>
                                                </div>
                                            </div>
                                        </div>-->

                                                                              
                                    </div>
                                </div>
                                <div class="chat-box">

                                    <div class="chat-not-selected">
                                        <p> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg> Click User To Chat</p>
                                    </div>

                                   

                                    <div class="chat-box-inner">
                                        <div class="chat-meta-user">
                                            <div class="current-chat-user-name"><span><img src="{{asset('admin-panel/assets/img/90x90.jpg')}}" alt="dynamic-image"><span class="name"></span></span></div>

                                            <!--<div class="chat-action-btn align-self-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone  phone-call-screen"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-video video-call-screen"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                                                <div class="dropdown d-inline-block">
                                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-2">
                                                        <a class="dropdown-item" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> Settings</a>
                                                        <a class="dropdown-item" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg> Mail</a>
                                                        <a class="dropdown-item" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg> Copy</a>
                                                        <a class="dropdown-item" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Delete</a>
                                                        <a class="dropdown-item" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg> Share</a>
                                                    </div>
                                                </div>
                                            </div>-->
                                        </div>
                                        <div class="chat-conversation-box">
                                            <div id="chat-conversation-box-scroll" class="chat-conversation-box-scroll">

                                                @foreach($customers as $customerId)
                                                <?php
                                                //dd($customers);
                                                    $customer=\App\Models\User::find($customerId->customer_id);
                                                    //dd($customer);
                                                    $lastMessage=\App\Models\Chat::where('hotel_id',Auth::user()->associated_hotel_id)->where('customer_id',$customer->id)->orderBy('created_at','desc')->first();

                                                    $messages=\App\Models\Chat::where('hotel_id',Auth::user()->associated_hotel_id)->where('customer_id',$customer->id)->orderBy('created_at','asc')->get();
                                                 ?>
                                                <div class="chat" data-chat="person{{$customer->id}}" id="chat-{{$customer->id}}">
                                                    <div class="conversation-start">
                                                        <span>{{$lastMessage->created_at}}</span>
                                                    </div>
                                                    @foreach($messages as $msg)
                                                    <?php
                                                        $msg->read="yes";
                                                        $msg->Save();
                                                     ?>
                                                    @if($msg->sender=="customer")
                                                    <div class="bubble you">
                                                        {{$msg->message}}
                                                    </div>
                                                    @endif
                                                    @if($msg->sender=="hotel-manager")
                                                    <div class="bubble me">
                                                        {{$msg->message}}
                                                    </div>
                                                    @endif
                                                    
                                                    @endforeach
                                                </div>
                                                @endforeach
                                                <!--
                                                <div class="chat" data-chat="person2">
                                                    <div class="conversation-start">
                                                        <span>Today, 5:38 PM</span>
                                                    </div>
                                                    <div class="bubble you">
                                                        Hello!
                                                    </div>
                                                    <div class="bubble me">
                                                        Hey!
                                                    </div>
                                                    <div class="bubble me">
                                                        How was your day so far.
                                                    </div>
                                                    <div class="bubble you">
                                                        It was a bit dramatic.
                                                    </div>
                                                </div>
                                                <div class="chat" data-chat="person3">
                                                    <div class="conversation-start">
                                                        <span>Today, 3:38 AM</span>
                                                    </div>
                                                    <div class="bubble me">
                                                        Hey Buddy.
                                                    </div>
                                                    <div class="bubble me">
                                                        What's up
                                                    </div>
                                                    <div class="bubble you">
                                                        I am sick
                                                    </div>
                                                    <div class="bubble you">
                                                        Not comming to office today.
                                                    </div>
                                                </div>-->
                                                
                                                
                                            </div>
                                        </div>
                                        <div class="chat-footer">
                                            <div class="chat-input">
                                                <form class="chat-form" action="javascript:void(0);">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                                    <input type="text" class="mail-write-box form-control" placeholder="Message"/>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="footer-wrapper">
            <br>
                <div class="footer-section f-section-1">

                    <p class="" style="margin-top: 130px;margin-right: 350px">{{$dynamic->copyright}}</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="" style="margin-top: 130px">{{$dynamic->copyright}}</p>
                </div>
            </div>
        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->
    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{asset('admin-panel/assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('admin-panel/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('admin-panel/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin-panel/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('admin-panel/assets/js/app.js')}}"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
            function checkChat(){
                
                var base_url = "http://giovannis37.sg-host.com";
                $.ajax({
                    url:base_url+'/update-chat',
                    type:'get',
                    dataType:'json',
                    success:function (response) {
                        //console.log(response.msg);
                        if(response.update==="yes"){
                            var customerId=response.customer_id;
                            var chatMessageValue=response.msg;
                            $messageHtml = '<div class="bubble you">' + chatMessageValue + '</div>';
                            //console.log($messageHtml);
                            $("#chat-"+customerId).append($messageHtml);
                            const getScrollContainer = document.querySelector('.chat-conversation-box');
                            getScrollContainer.scrollTop = getScrollContainer.scrollHeight;
                        }
                    }
                });

                setTimeout(checkChat, 5000);
            }

            checkChat();
        });
    </script>
    <script src="{{asset('admin-panel/assets/js/custom.js')}}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{asset('admin-panel/assets/js/apps/mailbox-chat.js')}}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

    
</body>
</html>