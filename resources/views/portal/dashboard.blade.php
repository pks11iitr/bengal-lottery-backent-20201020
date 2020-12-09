@extends('layouts.portal-layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if(Session::has("success"))
                <div class="alert alert-success alert-dismissible show animated zoomIn" role="alert">
                    {{ Session::get("success") }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(Session::has("error"))
                <div class="alert alert-danger alert-dismissible show animated zoomIn" role="alert">
                    {{ Session::get("error") }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
        @endif
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Agents System</span>
                            <span class="info-box-number">
                  {{$totalagent??'0'}}
{{--                  <small>%</small>--}}
                </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Bengal Lottery</span>
                            <span class="info-box-number">0</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Game</span>
                            <span class="info-box-number"> {{$totalgames??'0'}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Commission</span>
                            <span class="info-box-number">{{$total??0}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-header">--}}
{{--                            <h5 class="card-title">Monthly Recap Report</h5>--}}

{{--                            <div class="card-tools">--}}
{{--                                <button type="button" class="btn btn-tool" data-card-widget="collapse">--}}
{{--                                    <i class="fas fa-minus"></i>--}}
{{--                                </button>--}}
{{--                                <div class="btn-group">--}}
{{--                                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">--}}
{{--                                        <i class="fas fa-wrench"></i>--}}
{{--                                    </button>--}}
{{--                                    <div class="dropdown-menu dropdown-menu-right" role="menu">--}}
{{--                                        <a href="#" class="dropdown-item">Action</a>--}}
{{--                                        <a href="#" class="dropdown-item">Another action</a>--}}
{{--                                        <a href="#" class="dropdown-item">Something else here</a>--}}
{{--                                        <a class="dropdown-divider"></a>--}}
{{--                                        <a href="#" class="dropdown-item">Separated link</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <button type="button" class="btn btn-tool" data-card-widget="remove">--}}
{{--                                    <i class="fas fa-times"></i>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- /.card-header -->--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-8">--}}
{{--                                    <p class="text-center">--}}
{{--                                        <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>--}}
{{--                                    </p>--}}

{{--                                    <div class="chart">--}}
{{--                                        <!-- Sales Chart Canvas -->--}}
{{--                                        <canvas id="salesChart" height="180" style="height: 180px;"></canvas>--}}
{{--                                    </div>--}}
{{--                                    <!-- /.chart-responsive -->--}}
{{--                                </div>--}}
{{--                                <!-- /.col -->--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <p class="text-center">--}}
{{--                                        <strong>Goal Completion</strong>--}}
{{--                                    </p>--}}

{{--                                    <div class="progress-group">--}}
{{--                                        Add Products to Cart--}}
{{--                                        <span class="float-right"><b>160</b>/200</span>--}}
{{--                                        <div class="progress progress-sm">--}}
{{--                                            <div class="progress-bar bg-primary" style="width: 80%"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!-- /.progress-group -->--}}

{{--                                    <div class="progress-group">--}}
{{--                                        Complete Purchase--}}
{{--                                        <span class="float-right"><b>310</b>/400</span>--}}
{{--                                        <div class="progress progress-sm">--}}
{{--                                            <div class="progress-bar bg-danger" style="width: 75%"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <!-- /.progress-group -->--}}
{{--                                    <div class="progress-group">--}}
{{--                                        <span class="progress-text">Visit Premium Page</span>--}}
{{--                                        <span class="float-right"><b>480</b>/800</span>--}}
{{--                                        <div class="progress progress-sm">--}}
{{--                                            <div class="progress-bar bg-success" style="width: 60%"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <!-- /.progress-group -->--}}
{{--                                    <div class="progress-group">--}}
{{--                                        Send Inquiries--}}
{{--                                        <span class="float-right"><b>250</b>/500</span>--}}
{{--                                        <div class="progress progress-sm">--}}
{{--                                            <div class="progress-bar bg-warning" style="width: 50%"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!-- /.progress-group -->--}}
{{--                                </div>--}}
{{--                                <!-- /.col -->--}}
{{--                            </div>--}}
{{--                            <!-- /.row -->--}}
{{--                        </div>--}}
{{--                        <!-- ./card-body -->--}}
{{--                        <!-- /.card-footer -->--}}
{{--                    </div>--}}
{{--                    <!-- /.card -->--}}
{{--                </div>--}}
{{--                <!-- /.col -->--}}
{{--            </div>--}}
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">

                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Recently Agents</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>UserName</th>
                                        <th>Deposit</th>
                                        <th>Withdraw</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($agents as $code)
                                    <tr>
                                        <td>{{$code->email??''}}</td>
                                        <td><span class="badge badge-success">{{$code->deposit??''}}</span></td>
                                        <td>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20">{{$code->withdraw}}</div></td>
                                           <td> <div class="sparkbar" data-color="#00a65a" data-height="20">@if($code->status==1){{'Active'}}@elseif($code->status==0){{'Inactive'}}@else{{'Blocked'}}@endif</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
{{--                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>--}}
                            <a href="#" class="btn btn-sm btn-secondary float-right">View All</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

                <div class="col-md-4">

                    <!-- PRODUCT LIST -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recently Added Agents</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <!-- /.card-body -->
{{--                        <div class="card-footer text-center">--}}
{{--                            <a href="#" class="uppercase">View All Agents</a>--}}
{{--                        </div>--}}
                        <!-- /.card-footer -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($games as $gm)
                                        <tr>
                                            <td>{{$gm->name??''}}</td>
                                            <td><span class="badge badge-success">{{$gm->close_date??''}}</span></td>
                                            <td>
                                                <div class="sparkbar" data-color="#00a65a" data-height="20">{{$gm->game_time}}</div></td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
