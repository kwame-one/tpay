@extends('layouts.base')

@section('title', 'Account')

@section('css')
	<link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico') }}">
    <!-- <link href="../../../../../fonts.googleapis.com/css9764.css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/app.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu-modern.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/sweetalert.css') }}">
@endsection



@section('content')
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">Account</h3>
            <div class="row breadcrumbs-top">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item active">Account
                  </li>
                </ol>
              </div>
            </div>
          </div>
          <div class="content-header-right col-md-6 col-12">
          </div>
        </div>
        <div class="content-body"><!-- Simple User Cards -->
            <section id="configuration">
                <div class="row">
                    <div class="col-md-6 col-xs-12" style="margin: auto">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Change Password</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <form class="form" method="post" action="#">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="old">Current Password</label>
                                                    <input type="password" name="old" id="old" class="form-control" required="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="password">New Password</label>
                                                    <input type="password" name="password" id="password" class="form-control" required="">
                                                    @if($errors->has('password'))
                                                        <div style="color: red">{{ $errors->first('password') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Retype Password</label>
                                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions" align="center">
                                            <button type="button" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> Cancel
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-check-square-o"></i> Change
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
      </div>
    </div>
@endsection


@section('js')
	<script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/core/app-menu.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/core/app.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}" type="text/javascript"></script>
    @if(session('invalid'))
        <script type="text/javascript">
            swal('Oops', 'Invalid Password', 'error');
        </script>
    @elseif(session('success'))
        <script type="text/javascript">
            swal('success', 'Password Changed Successfully', 'success');
        </script>
    @endif

@endsection