@extends('layouts.base')

@section('title', 'Add Administrators')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/vendors.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/simple-line-icons/style.min.css') }}">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/weather-icons/climacons.min.css') }}"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/app.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu-modern.css') }}">

    <style type="text/css">
        .error {
            color: red;
        }
    </style>

@endsection



@section('content')
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">List</h3>
            <div class="row breadcrumbs-top">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a>
                  </li>
                   <li class="breadcrumb-item">Administrators
                  </li>
                  <li class="breadcrumb-item active">Add New
                  </li>
                </ol>
              </div>
            </div>
          </div>
         <!--  <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
                <a href="#" target="_blank" class="btn btn-outline-primary"><i class="ft-download icon-left"></i> Download</a>
              </div>
            </div>
          </div> -->
        </div>
          <div class="content-body"><!-- Simple User Cards -->
            <section id="configuration">
                <div class="row">
                    <div class="col-md-6 col-xs-12" style="margin: auto">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">New Administrator Details</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <form class="form" method="post" action="{{ route('admin.store') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="surname">Surname</label>
                                                    <input type="text" name="surname" id="surname" class="form-control" required value="{{ old('surname') }}">
                                                    @if($errors->has('surname'))
                                                        <span class="error">{{$errors->first('surname')}}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="other_names">Other Names</label>
                                                    <input type="text" name="other_names" id="other_names" class="form-control" required="" value="{{ old('other_names') }}">
                                                    @if($errors->has('other_names'))
                                                        <span class="error">{{$errors->first('other_names')}}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" name="email" id="email" class="form-control" required="" value="{{ old('email') }}">
                                                    @if($errors->has('email'))
                                                        <span class="error">{{$errors->first('email')}}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="contact">Contact</label>
                                                    <input type="text" name="contact" id="contact" class="form-control" required="" value="{{ old('contact') }}">
                                                    @if($errors->has('contact'))
                                                        <span class="error">{{$errors->first('contact')}}</span>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-actions" align="center">
                                            <button type="button" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> Cancel
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-check-square-o"></i> Add
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
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/core/app.min.js') }}" type="text/javascript"></script> 

    @if(session('error'))
        <script type="text/javascript">
            swal("Oops", 'Error adding admin', 'error');
        </script>
    @elseif(session('success'))
        <script type="text/javascript">
            swal('success', 'Admin added successfully', 'success');
        </script>
    @endif   
@endsection
