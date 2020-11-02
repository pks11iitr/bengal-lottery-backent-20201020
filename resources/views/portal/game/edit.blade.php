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
                        <h1>Edit Game</h1>
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

                                    <li class="nav-item"><a class="nav-link" href="#companyDetail" data-toggle="tab">Update Game Details</a></li>
                                    {{--                                    <li class="nav-item"><a class="nav-link" href="#changePassword" data-toggle="tab">Change Password</a></li>--}}
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">

                                    <!-- /.tab-pane -->

                                    <div class="active tab-pane" id="companyDetail">
                                        <form id="frmEditLoc" action="{{route('gameupdate',['id'=>$game->id])}}" method="post">
                                            {{ csrf_field() }}
                                            <h6 class="text-success"><b>UPDATE GAME</b></h6>
                                            <hr>
                                            <div class="container-fluid" id="detailsC">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="text-muted" for="cname">Name <small class="text-success">*</small> :</label>
                                                            <input type="text" id="name" name="name" class="form-control" placeholder="Game Name" required value="{{$game->name}}">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="text-muted" for="cemail">Close Date <small class="text-success">*</small> :</label>
                                                            <input type="date" id="close_date" name="close_date" class="form-control" placeholder="Close Date" required value="{{$game->orginal}}">
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="text-muted" for="creg">Game Time<small class="text-success">*</small> :</label>
                                                            <input type="time" id="game_time" name="game_time" class="form-control" placeholder="Game Time" required value="{{$game->time}}">

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="text-muted" for="cemail">Game Price <small class="text-success">*</small> :</label>
                                                            <input type="number" id="price" name="price" class="form-control" placeholder="Price" required min="0" value="{{$game->price}}">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="text-muted" for="cemail">Degit Number <small class="text-success">*</small> :</label>
                                                            <input type="text" id="degit" name="degit" class="form-control" placeholder="degit " required  value="{{$game->degit}}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Is Active</label>
                                                            <select class="form-control" name="isactive" required>
                                                                <option selected="selected"
                                                                        value="1" {{$game->isactive==1?'selected':''}}>Active
                                                                </option>
                                                                <option value="0" {{$game->isactive==0?'selected':''}}>Inactive
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <!-- /.form-group -->
                                                    </div>

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
