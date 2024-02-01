<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('global.site_title') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/header.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/materialicons.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/coreui_font.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/font_icon.css')}}" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
   
   
    @yield('styles')
</head>
 <style>
    .hiddenEvent{display: none;}
.fc-other-month .fc-day-number { display:none;}

td.fc-other-month .fc-day-number {
     visibility: hidden;
}
</style>
<body class="app header-fixed sidebar-fixed aside-menu-fixed pace-done sidebar-lg-show">
    <header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <span class="navbar-brand-full"><img src="{{url('/images/kingranch_logo.png')}}" height="50" width="160"
                    style="margin-bottom:3%">
                <span class="navbar-brand-minimized">K</span>
        </a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav ml-auto">
            @if(count(config('panel.available_languages', [])) > 1)
            <li class="nav-item dropdown d-md-down-none">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    {{ strtoupper(app()->getLocale()) }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @foreach(config('panel.available_languages') as $langLocale => $langName)
                    <a class="dropdown-item"
                        href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }}
                        ({{ $langName }})</a>
                    @endforeach
                </div>
            </li>
            @endif
        </ul>
        <div style="margin-right:5%">
       <div class="account-item clearfix js-item-menu show-dropdown">
                                        
                                        <div class="content content2">
                                            <a href="#"><i class="nav-icon fas fa-user-circle"></i>&nbsp;<?php echo session()->get('uname'); ?></a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                
                                                    <h5 class="name">
                                                        <p style="font-size: large;"><?php echo session()->get('uname'); ?></p>
                                                    </h5>
                                                    <p><?php echo session()->get('useremail'); ?></p>
                                                
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="/logoutfromdashboard" style="text-align: center">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
        </div>  
</div>




    </header>

    <div class="app-body">
      
        @include('partials.menu')
     
        <main class="main">


            <div style="padding-top: 20px" class="container-fluid">

                @yield('content')

            </div>


        </main>
        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>

s
    @yield('scripts')

</body>

</html>