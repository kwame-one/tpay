@extends('layouts.base')

@section('title', 'Dashboard')

@section('css')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/weather-icons/climacons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/charts/apexcharts.css') }}">

    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.min.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu-modern.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/simple-line-icons/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/card-statistics.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/vertical-timeline.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker.css') }}">
    <!-- END: Page CSS-->
@endsection


@section('content')
     <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">

                <div class="row grouped-multiple-statistics-card">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                              <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon primary d-flex justify-content-center mr-3">
                                  <i class="icon p-1 icon-users customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                  <h3 class="heading-text text-bold-600">{{ $users }}</h3>
                                  <p class="sub-heading">Total Users</p>
                                </div>
                              </div>
                            </div>

                            <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                              <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon danger d-flex justify-content-center mr-3">
                                  <i class="icon p-1 icon-users customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                  <h3 class="heading-text text-bold-600">{{ $drivers }}</h3>
                                  <p class="sub-heading">Total Drivers</p>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                              <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon success d-flex justify-content-center mr-3">
                                  <i class="icon p-1 icon-wallet customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                  <h3 class="heading-text text-bold-600">{{ $wallets }}</h3>
                                  <p class="sub-heading">Total Wallets</p>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                              <div class="d-flex align-items-start">
                                <span class="card-icon warning d-flex justify-content-center mr-3">
                                  <i class="icon p-1 icon-wallet customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                  <h3 class="heading-text text-bold-600">{{ $payments }}</h3>
                                  <p class="sub-heading">Total Payments</p>
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                </div>

                 <div class="row grouped-multiple-statistics-card">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                              <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon primary d-flex justify-content-center mr-3">
                                  <i class="icon p-1 icon-wallet customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                  <h3 class="heading-text text-bold-600">{{ $activatedWallets }}</h3>
                                  <p class="sub-heading">Activated Wallets</p>
                                </div>
                              </div>
                            </div>

                            <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                              <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon danger d-flex justify-content-center mr-3">
                                  <i class="icon p-1 icon-wallet customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                  <h3 class="heading-text text-bold-600">{{ $deactivatedWallets }}</h3>
                                  <p class="sub-heading">Deactivated Wallets</p>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                              <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon success d-flex justify-content-center mr-3">
                                  <i class="icon p-1 fa fa-money customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                  <h3 class="heading-text text-bold-600">{{ $deposits }}</h3>
                                  <p class="sub-heading">Total Deposits</p>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                              <div class="d-flex align-items-start">
                                <span class="card-icon success d-flex justify-content-center mr-3">
                                  <i class="icon p-1 fa fa-money customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                  <h3 class="heading-text text-bold-600">{{ $withdrawals }}</h3>
                                  <p class="sub-heading">Total Withdrawals</p>
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                </div>



              <div class="row match-height">
                  <div class="col-xl-6 col-lg-12">
                      <div class="card">
                          <div class="card-header border-0">
                              <h4 class="card-title">User Statistics</h4>
                          </div>
                          <div class="card-content">
                              <div class="card-body">
                                    <div id="user-pie-simple-chart"></div>
                                </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-xl-6 col-lg-12">
                      <div class="card">
                          <div class="card-header border-0">
                              <h4 class="card-title">Digital Wallets Statistics</h4>
                          </div>
                          <div class="card-content">
                              <div class="card-body">
                                     <div id="wallet-pie-simple-chart"></div>
                                </div>
                          </div>
                      </div>
                  </div>
              </div>

              <section id="flot-bar-charts">
                <!-- Simple Bar Chart -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                  <div class="col-6 col-xs-6">
                                    <h4 class="card-title">Deposits and Withdrawals Statistics</h4>
                                  </div>
                                  <div class="col-6 col-xs-6" align="right">
                                    <input type="text" name="daterange" value="01/01/2018 - 01/15/2018" class="form-control col-lg-6"/>
                                  </div>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div id="bar-chart" class="height-400"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->

@endsection



@section('js')
    <script src=" {{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/apexcharts/apexcharts.min.js') }}"></script>
    <script src=" {{ asset('app-assets/js/core/app-menu.min.js') }}"></script>
    <script src=" {{ asset('app-assets/js/core/app.min.js') }}"></script>
    <script src=" {{ asset('app-assets/js/scripts/customizer.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/flot/jquery.flot.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/flot/jquery.flot.resize.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/flot/jquery.flot.categories.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
    <script type="text/javascript">

      //bar chart
      $(window).on("load",function(){$.plot("#bar-chart",[[["Deposits","{!! $deposits !!}"],["Withdrawals","{!! $withdrawals !!}"]]],{series:{bars:{show:!0,barWidth:.6,align:"center",lineWidth:0,fill:!0,fillColor:{colors:[{opacity:.2},{opacity:.8}]}}},yaxis:{min:0},xaxis:{mode:"categories",tickLength:0},grid:{borderWidth:1,borderColor:"transparent",color:"#999",minBorderMargin:20,labelMargin:10,margin:{top:8,bottom:20,left:20}},colors:["#4D0096"]})});

      var $primary="#00b5b8",$secondary="#2c3648",$success="#0f8e67",$info="#179bad",$warning="#ffb997",$danger="#ff8f9e",$themeColor1=[$primary,$success,$warning,$info,$danger,$secondary]

      userSimpleChart={chart:{height:350,type:"pie"},labels:["Drivers","Users"],series:["{!! $drivers !!}", "{!! $users !!}"],  dataLabels: {
          formatter: function (val, opts) {
              return opts.w.config.series[opts.seriesIndex]
          },
        },responsive:[{breakpoint:1200,options:{chart:{width:300},legend:{position:"bottom"}}},{breakpoint:768,options:{chart:{width:520},legend:{position:"right"}}},{breakpoint:620,options:{chart:{width:450},legend:{position:"right"}}},{breakpoint:480,options:{chart:{width:250},legend:{position:"bottom"}}}],fill:{colors:$themeColor1}}
      var user_pie_simple_chart= new ApexCharts(document.querySelector("#user-pie-simple-chart"),userSimpleChart);
      user_pie_simple_chart.render();


      var themeColor2=[$success,$danger]
      walletSimpleChart={chart:{height:350,type:"pie"},labels:["Used Wallets","Unused Wallets"],series:["{!! $takenWallets !!}", "{!! $unUsedWallets !!}"],  dataLabels: {
          formatter: function (val, opts) {
              return opts.w.config.series[opts.seriesIndex]
          },
        },responsive:[{breakpoint:1200,options:{chart:{width:300},legend:{position:"bottom"}}},{breakpoint:768,options:{chart:{width:520},legend:{position:"right"}}},{breakpoint:620,options:{chart:{width:450},legend:{position:"right"}}},{breakpoint:480,options:{chart:{width:250},legend:{position:"bottom"}}}],fill:{colors:themeColor2}}
      var wallet_pie_simple_chart= new ApexCharts(document.querySelector("#wallet-pie-simple-chart"),walletSimpleChart);
      wallet_pie_simple_chart.render();

      $('input[name="daterange"]').daterangepicker({
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
          format: 'MM/DD/YYYY'
        }
      }, function(start, end, label) {
        alert("You are years old!");
      });


    </script>

@endsection


