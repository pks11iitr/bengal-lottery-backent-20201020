<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title></title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('portal/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('portal/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Theme style -->
    @yield('stylesheets')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('portal/css/adminlte.min.css')}}">
     <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        .main-footer,.content-wrapper {
            margin: 0px !important;
        }
        .contat_in_info ul li {
                display: flex;
                align-items: center;
                 margin-left: 0px;
                 border-right: 0px;
                 padding-right: 0px;
        }
        .contat_in_info {
            margin-top: 10px;
        }
    </style>

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

    <div class="top_headr">
            <div class="full_width w_f_color f_box f_btwn main_top_head_con">
                <div class="offic_timing_info f_box f_btwn info_offc_add">
                    <div class="office_sddress">
                    <span> <i class="fa fas-map-marker" aria-hidden="true"></i>
                    </span>
                        <label for="" class="f_13">KUILL LOTTERY System</label>
                    </div>
{{--                    <div class="off_timing row_padding">--}}
{{--                        <span> <i class="fa fas-clock-o" aria-hidden="true"></i></span>--}}
{{--                        <label for="" class="f_13">Anmoore Road Brooklyn, NY 11230</label>--}}
{{--                    </div>--}}
                </div>
                <div class="social_medi_con row_padding f_box f_btwn">
                    <div class="social_icon_cont">
                        <ul class="f_box my_admin_socail">
                            <li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i>
                                </a></li>
                            <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i>
                                </a></li>
                            <li><a href=""><i class="fa fa-pinterest-p" aria-hidden="true"></i>
                                </a></li>
                            <li><a href=""><i class="fa fa-linkedin" aria-hidden="true"></i>

                                </a></li>
                        </ul>
                    </div>
                    <div class="get_qoute_btn">
{{--                        <a href="" class="get_started" style="padding: 10px;border-radius: 3px">GET A QUOTE</a>--}}
                        @if(auth()->user())
                            <a class="dropdown-item get_started" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            </form>
                        @else
                            <a href="{{route('login')}}" class="get_started">Login</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="logo_header full_width row_padding box_sizzing" style="padding: 15px 10px !important;">
            <div class="second_heade full_width f_box f_btwn my_admin_head">
                <div class="logo_container">
                    <h4>Welcome to, {{ auth()->user()->email}}</h4>
                    <p style="text-align:left">
                         Balance Amount: {{round(App\Models\Transaction::balance(auth()->user()->id),2)}} &nbsp; &nbsp;Rate:({{auth()->user()->rate??0}}) &nbsp;&nbsp; @if(isset($total))Total Commission:   {{round($total,2)}}@endif
                    </p>
                    Available Balance: {{round(\App\Models\Balance::avl_balance(auth()->user()->id),2)}} &nbsp;&nbsp;&nbsp;    Available Commission: {{round(\App\Models\Commission::avl_commission(auth()->user()->id),2)}}
                    <p style="text-align:left;color:blue;font-weight: bold ">

                    </p>
                    <a href="{{route('login')}}">
{{--                        <img src="/images/new-logo.jpeg" alt="">--}}
                    </a>
                </div>
                @if(Route::currentRouteName()!='product.info')
                <div class="contact_info admin_menu">
                    <div class="contat_in_info">
                        <ul>
                            <li>
                                <a href="{{route('dashboard')}}" class="btn btn-info">Dashboard</a>
                            </li>
                            <li>
                                <a href="{{route('paymenthistoryparent')}}" class="btn btn-info">Payment History</a>
                            </li>
                            <li>
                                <a href="{{route('agents')}}" class="btn btn-info">Agents </a>
                            </li>
                            @if(auth()->user()->hasRole('admin'))
                            <li>
                                <a href="{{route('gamelist')}}" class="btn btn-info">Add Game </a>
                            </li>
                            @else
                           {{-- <li>
                                <a href="{{route('gamelist')}}" class="btn btn-info">Add Game </a>
                            </li>--}}

                            @endif

{{--                            <li>--}}
{{--                                <a href="" class="btn btn-info">OLD History</a>--}}
{{--                            </li>--}}
@if(auth()->user()->hasRole('admin'))
                            <li>
                                <a href="{{route('notification')}}" class="btn btn-info">Notification</a>
                            </li>
                                <li>
                                    <a href="{{route('changepassword')}}" class="btn btn-info">Change Password</a>
                                </li>

                            @endif
                            <li class="p_zero_b">

                            </li>
                        </ul>
                    </div>
                </div>

                <!-----------------------Mobile-Nav----------->
                <div class="my_muneu_con">
                        <span class="my_men"><i class="fa fa-bars" aria-hidden="true"></i></span>
                        <div class="mobile_menu admin_menu_cont">
                        <div class="in_menu row_padding">
                <ul class="admin_menu_list">
                <li>
                                <a href="{{route('dashboard')}}" >Dashboard</a>
                            </li>
                            <li>
                                <a href="{{route('agents')}}" >Agents</a>
                            </li>

                            @if(auth()->user()->hasRole('admin'))
                            <li>
                                <a href="{{route('gamelist')}}" >Add Game</a>
                            </li>
                            @endif
                            <li>
                                <a href="" >Old History</a>
                            </li>
                            <li>
                                <a href="{{route('notification')}}" class="btn btn-info">Notification</a>
                            </li>
                            <li class="p_zero_b">
                            @if(auth()->user())
                            <a class="dropdown-item get_started" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            </form>
                        @else
                            <a href="{{route('login')}}" class="get_started">Login</a>
                        @endif
                            </li>

                </ul>
            </div>
                        </div>
                    </div>
                <!-----------------------Mobile-Nav------------>
                    @endif
            </div>
        </div>

    <!-- Content Wrapper. Contains page content -->
    @yield('content')
    <!-- /.content-wrapper -->



    <!-- Main Footer -->
    <footer class="main-footer">
        <strong> <a href="{{route('login')}}"></a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.0.5
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('portal/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('portal/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('portal/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('portal/js/adminlte.js')}}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('portal/js/demo.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('portal/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('portal/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('portal/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('portal/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('portal/plugins/chart.js/Chart.min.js')}}"></script>

<!-- PAGE SCRIPTS -->
<!-- <script src="{{asset('portal/js/pages/dashboard2.js')}}"></script> -->


<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <!-- <script src="{{ asset('js/vfs_fonts.js') }}"></script> -->
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <!-- <script src="{{ asset('js/buttons.print.min.js') }}"></script> -->
    <script src="{{ asset('js/jszip.min.js') }}"></script>


@yield('scripts')
<script>
 $(".my_men").click(function(){
      $(".mobile_menu").toggle();
  });
</script>
</body>
</html>
