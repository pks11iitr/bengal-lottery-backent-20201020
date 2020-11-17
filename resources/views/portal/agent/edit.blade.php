@extends('layouts.portal-layout')

@section('content')
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
                        <h1>update Winner</h1>
                    </div>
                    <div class="col-sm-6">
                        <!-- <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol> -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">

                                    <li class="nav-item"><a class="nav-link" href="#companyDetail" data-toggle="tab">Update Game winner</a></li>
                                    {{--                                    <li class="nav-item"><a class="nav-link" href="#changePassword" data-toggle="tab">Change Password</a></li>--}}
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">

                                    <!-- /.tab-pane -->

                                    <div class="active tab-pane" id="companyDetail">
                                        <form id="frmEditLoc" action="{{route('historyupdate',['id'=>$game->id])}}" method="post">
                                            {{ csrf_field() }}
                                            <h6 class="text-success"><b>UPDATE Winner</b></h6>
                                            <hr>
                                            <div class="container-fluid" id="detailsC">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="text-muted" for="cname">Name <small class="text-success">*</small> :</label>
                                                            <input type="text" id="name" name="name" class="form-control" placeholder="Game Name" readonly required value="{{$game->name}}">
                                                        </div>
                                                    </div>

                                                                                                        <div class="col-sm-6">
                                                                                                            <div class="form-group">
                                                                                                                <label class="text-muted" for="creg">Winning Amount<small class="text-success">*</small> :</label>
                                                                                                                <input type="number" id="winning_amount" name="winning_amount" class="form-control" min="0" placeholder="Winning Amount" required >

                                                                                                            </div>
                                                                                                        </div>


                                                </div>

                                                <div class="row">
{{--                                                    <div class="col-sm-6">--}}
{{--                                                        <div class="form-group">--}}
{{--                                                            <label class="text-muted" for="creg">Winning Amount<small class="text-success">*</small> :</label>--}}
{{--                                                            <input type="number" id="game_time" name="winning_amount" class="form-control" min="0" placeholder="Winning Amount" required >--}}

{{--                                                        </div>--}}
{{--                                                    </div>--}}
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="text-muted" for="cemail">Game Winning Digit <small class="text-success">*</small> :</label>
                                                            <input type="number" id="bid_digit" name="bid_digit" class="form-control" placeholder=" winning bid digit" required min="0" >
                                                        </div>
                                                    </div>

{{--                                                    <div class="col-md-6">--}}
{{--                                                        <div class="form-group">--}}
{{--                                                            <label>Winning Status</label>--}}
{{--                                                            <select class="form-control" name="status" required>--}}
{{--                                                                <option selected="selected"--}}
{{--                                                                        value="Won" {{$game->status=='Won'?'selected':''}}>Won--}}
{{--                                                                </option>--}}
{{--                                                                <option value="Lose" {{$game->status=='Lose'?'selected':''}}>Lose--}}
{{--                                                                </option>--}}
{{--                                                            </select>--}}
{{--                                                        </div>--}}
{{--                                                        <!-- /.form-group -->--}}
{{--                                                    </div>--}}

                                                </div>

                                            </div>


                                            <br>

                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <input type="submit" name="submit" value="Save" class="btn btn-sm btn-success pull-right float-sm-right">
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

@endsection

@section('scripts')

@endsection
