@extends('layouts.portal-layout')

@section('content')

    <style type="text/css">
        .ui-menu .ui-menu-item a {font-size: 12px; } .ui-autocomplete {position: absolute; top: 0; left: 0; z-index: 1510 !important; float: left; display: none; min-width: 160px; width: 160px; padding: 4px 0; margin: 2px 0 0 0; list-style: none; background-color: #ffffff; border-color: #ccc; border-color: rgba(0, 0, 0, 0.2); border-style: solid; border-width: 1px; -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px; -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); -webkit-background-clip: padding-box; -moz-background-clip: padding; background-clip: padding-box; *border-right-width: 2px; *border-bottom-width: 2px; } .ui-menu-item > a.ui-corner-all {display: block; padding: 3px 15px; clear: both; font-weight: normal; line-height: 18px; color: #555555; white-space: nowrap; text-decoration: none; } .ui-state-hover, .ui-state-active {color: #ffffff; text-decoration: none; background-color: #0088cc; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; background-image: none; cursor: pointer;}

        .selectImg {padding: 3px 5px;}
    </style>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
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

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible show animated zoomIn">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>History</h1>
                    </div>
{{--                    <div class="col-sm-6">--}}
{{--                        <a href="{{route('creategame')}}"   class="btn btn-info btn-sm float-sm-right">+ Add New</a>--}}
{{--                    </div>--}}
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">

                <div class="card-body">
                    <table class="table projects" id="allProducts">
                        <thead>
                        <tr>
                            <th style="width: 1%">
                                #
                            </th>
                            <th style="width: 10%">
                                Game Name
                            </th>
                            <th style="width: 15%">
                                Game Date
                            </th>
                            <th style="width: 15%">
                                Game Time
                            </th>
                            <th style="width: 15%">
                                Bid Number
                            </th>
                            <th style="width: 15%">
                                Bid Digit
                            </th>
                            <th style="width: 15%">
                                Bid QTY
                            </th>
                            <th style="width: 15%">
                                Game Price
                            </th>
                            <th style="width: 15%">
                                Draw Result
                            </th>
                            <th style="width: 15%">
                                Amount
                            </th>
                            <th style="width: 15%">
                                Status
                            </th>

{{--                            <th style="width: 10%; text-align: right">--}}
{{--                                Action--}}
{{--                            </th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($gamebook) && count($gamebook) > 0)
                            @foreach($gamebook as $key => $gmae)
                                <tr>
                                    <td>{{$key+1}}</td>

                                    <td style="text-transform: capitalize;">
                                        {{$gmae->name}}
                                    </td>
                                    <td style="text-transform: capitalize;">
                                        {{date('d M Y', strtotime($gmae->close_date))}}
                                    </td>
                                    <td style="text-transform: capitalize;">
                                        {{date('h:i A', strtotime($gmae->game_time))}}
                                    </td>
                                    <td style="text-transform: capitalize;">
                                        {{$gmae->bid_number}}
                                    </td>
                                    <td style="text-transform: capitalize;">
                                        {{$gmae->bid_digit}}
                                    </td>
                                    <td style="text-transform: capitalize;">
                                        {{$gmae->bid_qty}}
                                    </td>
                                    <td style="text-transform: capitalize;">
                                        {{$gmae->game_price}}
                                    </td>
                                    <td style="text-transform: capitalize;">
                                        {{$gmae->draw_result}}
                                    </td>
                                    <td style="text-transform: capitalize;">
                                        {{$gmae->winning_amount}}
                                    </td>
                                    @if($gmae->status=='Won')
                                    <td style="text-transform: capitalize;color: #00c054">

                                        {{$gmae->status}}
                                    </td>
                                    @else
                                        <td style="text-transform: capitalize;color: #BF1B00">

                                            {{$gmae->status}}
                                        </td>
                                    @endif

{{--                                    <td class="project-actions text-right">--}}
{{--                                        <a class="btn btn-primary btn-sm" href="{{route('historyedit',['id'=>$gmae->id])}}" title="Edit">--}}
{{--                                            <i class="fas fa-pencil-alt mr-1" aria-hidden="true"></i>--}}
{{--                                        </a>--}}
{{--                                       --}}
{{--                                    </td>--}}
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


@endsection



@section('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

@endsection
