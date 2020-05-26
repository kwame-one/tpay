<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Junior Youth (Immanuel Congregation) Database stores info about members of the church">
    <meta name="author" content="PerezTech">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title')</title>
    @yield('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/simple-line-icons/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/font-awesome/css/font-awesome.min.css') }}">
   <!--  <style type="text/css">
      td, th {
        text-align: center;
      }

      .main-menu.menu-dark .navigation > li.open {
        border-left: 0px solid #4D0096 !important;
      }

      .navbar-header {
        background: #4D0096 !important;
      }
      .main-menu.menu-dark {
        color: #fff !important;
        background: #4D0096 !important;
      }
      .main-menu.menu-dark .navigation {
        background: #4D0096 !important;
      }

      .main-menu.menu-dark .navigation > li.hover > a, .main-menu.menu-dark .navigation > li:hover > a, .main-menu.menu-dark .navigation > li.active > a {
          color: #fff !important;
          background: #4D0096 !important;
      }

      .main-menu.menu-dark .navigation > li > ul, .main-menu.menu-dark .navigation > li > ul > li:hover > a, .main-menu.menu-dark .navigation > li > ul > li.active > a{
        background: #4D0096 !important;
      }

      .main-menu.menu-dark .navigation > li.open > a {
        color: #fff !important;
        background: #4D0096 !important;
      }

      .main-menu.menu-dark .navigation > li.open .hover > a {
        background: #4D0096 !important;;
      }

    </style> -->
  </head>
  <body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- fixed-top-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
      <div class="navbar-wrapper">
        <div class="navbar-header">
          <ul class="nav navbar-nav flex-row position-relative">
            <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
            <li class="nav-item mr-auto"><a class="navbar-brand" href="#"><img class="brand-logo" alt="stack admin logo" src="{{ asset('app-assets/images/logo/stack-logo-light.png') }}">
              <h2 class="brand-text">Admin Portal</h2></a></li>
            <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
          </ul>
        </div>
        <div class="navbar-container content">
          <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="nav navbar-nav mr-auto float-left">
              <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
               <!-- <li class="nav-item d-none d-md-block"><a class="nav-link" href="#" id="dt"></a></li> -->
            </ul>
            <ul class="nav navbar-nav float-right">
              <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="avatar avatar-online"><img src="{{ asset('img/person.jpg') }}" alt="avatar"><i></i></span><span class="user-name">{{ Auth::user()->surname }} {{ Auth::user()->other_names }}</span></a>
                <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();"><i class="ft-power"></i> Logout</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
         <!--  <li class=" navigation-header"><span>General</span><i class=" ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="General"></i>
          </li> -->

          <li class="@if(Request::is('home')) {{'active'}} @endif nav-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
          </li>

          <li class="nav-item"><a href="#"><i class="fa fa-qrcode"></i><span class="menu-title" data-i18n="">Digital Wallets</span></a>
            <ul class="menu-content">
              <li class="@if(Request::is('wallets/generate')) {{'active'}} @endif"><a class="menu-item" href="{{ route('wallet.generate') }}">Generate</a>
              </li>
              <!-- <li><a class="menu-item" href="#">Activated</a> -->
              </li>
              <li class="@if(Request::is('wallets/all')) {{'active'}} @endif"><a class="menu-item" href="{{ route('wallet.all') }}">List</a>
              </li>
              <li class="@if(Request::is('user-wallets/all')) {{'active'}} @endif"><a class="menu-item" href="{{ route('user.wallets') }}">User wallets</a>
              </li>
            </ul>
          </li>

          <li class="@if(Request::is('payments')) {{'active'}} @endif nav-item"><a href="{{ url('payments') }}"><i class="fa fa-money"></i><span class="menu-title" data-i18n="">Payments</span></a>
          </li>

           <li class="@if(Request::is('transactions')) {{'active'}} @endif nav-item"><a href="{{ url('transactions') }}"><i class="fa fa-home"></i><span class="menu-title" data-i18n="">Transactions</span></a>
            </li>


             <li class=" nav-item"><a href="#"><i class="fa fa-users"></i><span class="menu-title" data-i18n="">Users</span></a>
              <ul class="menu-content">
                <li class="@if(Request::is('drivers')) {{'active'}} @endif"><a class="menu-item" href="{{ url('drivers') }}">Drivers</a>
                </li>
                <li class="@if(Request::is('users')) {{'active'}} @endif"><a class="menu-item" href="{{ url('users') }}">Normal</a>
                </li>
              </ul>
            </li>


            <li class=" nav-item"><a href="#"><i class="fa fa-user-secret"></i><span class="menu-title" data-i18n="">Administrators</span></a>
              <ul class="menu-content">
                <li class="@if(Request::is('admin/add')) {{'active'}} @endif"><a class="menu-item" href="{{ url('admin/add') }}">Add New</a>
                </li>
                <li class="@if(Request::is('admins')) {{'active'}} @endif"><a class="menu-item" href="{{ url('admins') }}">List</a>
                </li>
              </ul>
            </li>

          <li class="@if(Request::is('account')) {{'active'}} @endif nav-item"><a href="{{ url('account') }}"><i class="fa fa-lock"></i><span class="menu-title" data-i18n="">Account</span></a>
          </li>

        </ul>
      </div>
    </div>

    @yield('content')

    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <footer class="footer footer-static footer-light navbar-border">
      <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">Copyright  &copy; 2020 Final Year Project, All rights reserved. </p>
    </footer>

   @yield('js')

  </body>

</html>
