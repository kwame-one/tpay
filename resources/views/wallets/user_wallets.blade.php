@extends('layouts.base')

@section('title', 'User Digital Wallets')

@section('css')
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/simple-line-icons/style.min.css') }}">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/weather-icons/climacons.min.css') }}"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/app.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu-modern.css') }}">

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
                  <li class="breadcrumb-item"><a href="#">Digital Wallets</a>
                  </li>
                  <li class="breadcrumb-item active">List
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Digital Wallets</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <!-- <li><a data-action="collapse"><i class="ft-minus"></i></a></li> -->
                                        <!-- <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li> -->
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>Wallet</th>
                                                <th>User</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($userWallets as $w)

                                             <td><img src="{{$w->wallet->name}}" height="50" width="50"></td>
                                             <td>{{ $w->user->surname }} {{ $w->user->other_names }}</td>
                                             <td>{{ $w->status == 1 ? "Activated" : "Deactivated" }}</td>
                                             <td>
                                                @if($w->status == 1)
                                                  <a href="#" class="btn btn-sm btn-outline-danger" data-id="{{$w->id}}"><span class="icon-trash"></span> deactivate</a> 
                                                @else
                                                  <a href="#" class="btn btn-sm btn-outline-success" data-id="{{$w->id}}"><span class="icon-trash"></span> activate</a> 
                                                @endif
                                             </td>

                                           @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
      </div>
    </div>

      <form action="{{ route('wallet.delete') }}" hidden id="del-form" method="post">
        @csrf
        <input name="_method" value="delete">
        <input type="text" name="id" id="wallet_id">
      </form>

@endsection


@section('js')
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/core/app-menu.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/core/app.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/scripts/tables/datatables/datatable-basic.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
      $(".del").on('click', function(e){
        var id = $(this).data('id');
        e.preventDefault();
        swal({
          title: "Delete Wallet",
          text: "Are you sure?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((value) => {
           if(value) {
            $("#wallet_id").val(id);
            $("#del-form").submit();
           }
             
        });
      });
    </script>
    
    @if(session('success'))
      <script type="text/javascript">
        swal("Success", "wallet deleted successfully", "success");
      </script>
    @endif
@endsection