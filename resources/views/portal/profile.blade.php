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
                        <h1>Profile</h1>
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
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{asset('portal/img/user4-128x128.jpg')}}"
                                         alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{$user->first_name.' '.$user->last_name}}</h3>

                                <p class="text-muted text-center">{{$user->company_name}}</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Email</b> <a class="float-right">{{$user->email}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Mobile</b> <a class="float-right">{{$user->mobile}}</a>
                                    </li>
                                </ul>

{{--                                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>--}}
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- About Me Box -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Membership Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <strong><i class="fas fa-book mr-1"></i>Name:{{$user->plan->name??''}}</strong>

                                <p class="text-muted">
                                    {{$user->plan->description??''}}
                                </p>

                                <hr>

                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Total QR Limit:</strong>

                                <p class="text-muted">{{$user->plan->count}}</p>

                                <hr>

                                <strong><i class="fas fa-pencil-alt mr-1"></i> Remaining QR Limit:</strong>

                                <p class="text-muted">{{$user->qr_balance}}</p>

                                <hr>

                                <strong><i class="far fa-file-alt mr-1"></i> Plan Validity:</strong>

                                <p class="text-muted">Your Membership is Expiring on {{date('d/m/Y')}}</p>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                	<li class="nav-item"><a class="nav-link active" href="#profileDetails" data-toggle="tab">Profile Details</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#companyDetail" data-toggle="tab">Company Details</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#manufacturer" data-toggle="tab">Manufacturers</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#marketers" data-toggle="tab">Marketers</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#changePassword" data-toggle="tab">Change Password</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                	<div class="active tab-pane" id="profileDetails">

                                    	<h6 class="text-success"><b>COMPANY INFORMATION</b></h6>
                                    	<hr>
                                    	<div class="container-fluid" id="detailsC">
	                                    	<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="text-muted" for="cname">Name :</label>
														<input type="text" id="cname" name="company_name" class="form-control" placeholder="Company name like: XYZ Corp Pvt Ltd" required value="{{ $user->company_name }}" disabled>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="text-muted" for="creg">Registration No. :</label>
														<input type="text" id="creg" name="registration_number" class="form-control" placeholder="CIR-XXXXXX-XXXX" required value="{{ $user->registration_number }}" disabled>
													</div>
												</div>
{{--												<div class="col-sm-3">--}}
{{--													<div class="form-group">--}}
{{--														<label class="text-muted" for="cmark">Marketed By :</label>--}}
{{--														<input type="text" id="cmark" name="marketed_by" class="form-control" placeholder="Example Pvt Ltd" required value="{{ $user->marketed_by }}" disabled>--}}
{{--													</div>--}}
{{--												</div>--}}
	                                    	</div>

	                                    	<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="text-muted" for="cemail">Email :</label>
														<input type="email" id="cemail" name="company_email" class="form-control" placeholder="xyz@example.com" required value="{{ $user->company_email }}" disabled>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="text-muted" for="cphone">Phone No. :</label>
														<input type="text" id="cphone" name="company_phone" class="form-control" placeholder="120114451145" required value="{{ $user->company_phone }}" disabled>
													</div>
												</div>
	                                    	</div>
	                                    	<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="text-muted" for="caddress">Address :</label>
														<textarea id="caddress" name="company_address" class="form-control" placeholder="" cols="25" rows="4" required disabled>
															{{ $user->company_address }}
														</textarea>
													</div>
												</div>
	                                    	</div>
	                                    </div>

	                                    <br>
	                                    <h6 class="text-success"><b>CUSTOMER CARE INFORMATION</b></h6>
                                    	<hr>
                                    	<div class="container-fluid" id="detailsC">
	                                    	<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="text-muted" for="ccemail">Email Address :</label>
														<input type="email" id="ccemail" name="cc_email" class="form-control" placeholder="xyz@example.com" required value="{{ $user->cc_email }}" disabled>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="text-muted" for="ccphone">Phone No. :</label>
														<input type="text" id="ccphone" name="cc_phone" class="form-control" placeholder="120114451145" required value="{{ $user->cc_phone }}" disabled>
													</div>
												</div>
	                                    	</div>
	                                    	<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="text-muted" for="ccaddress">Address :</label>
														<textarea id="ccaddress" name="cc_address" class="form-control" placeholder="" cols="25" rows="4" required disabled>
															{{ $user->cc_address }}
														</textarea>
													</div>
												</div>
	                                    	</div>
	                                    </div>
	                                    <br>
	                                    <h6 class="text-success"><b>Manufacturers</b></h6>
	                                    <hr>
	                                    <div class="container-fluid" id="detailsC">
		                                    <div class="table-responsive">
		                                    	<table class="table projects" id="allManufacturer">
							                        <thead>
								                        <tr>
								                            <th style="width: 15%">
								                                Name
								                            </th>
{{--								                            <th style="width: 5%">--}}
{{--								                                Alias--}}
{{--								                            </th>--}}
								                            <th style="width: 20%">
								                                License No.
								                            </th>
								                            <th style="width: 20%">
								                                Address
								                            </th>
								                            <th style="width: 5%">
								                                Phone
								                            </th>
								                            <th style="width: 15%">
								                                City
								                            </th>
								                            <th style="width: 10%">
								                                State
								                            </th>
								                            <th style="width: 5%">
								                                Pincode
								                            </th>

								                        </tr>
							                        </thead>
							                        <tbody>
							                            @if(!empty($manufacturers) && count($manufacturers) > 0)
							                            @foreach($manufacturers as $key => $manufacturer)
							                            <tr>
							                                <td style="text-transform: capitalize;">{{$manufacturer->m_name}}</td>
{{--							                                <td>{{$manufacturer->m_alias}}</td>--}}
							                                <td>{{$manufacturer->m_license}}</td>
							                                <td>{{$manufacturer->m_address}}</td>
							                                <td>{{$manufacturer->phone_no}}</td>
							                                <td>{{$manufacturer->city_name}}</td>
							                                <td>{{$manufacturer->state_name}}</td>
							                                <td>{{$manufacturer->m_pincode}}</td>

							                            </tr>
							                            @endforeach
							                            @endif
							                        </tbody>
							                    </table>
							                </div>
							            </div>
                                        <br><br>
                                        <h6 class="text-success"><b>Marketers</b></h6>
                                        <hr>
                                        <div class="container-fluid" id="details">
                                            <div class="table-responsive">
                                                <table class="table projects" id="allMarketers">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 15%">
                                                            Name
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!empty($marketers) && count($marketers) > 0)
                                                        @foreach($marketers as $key => $marketer)
                                                            <tr>
                                                                <td style="text-transform: capitalize;">{{$marketer->name}}</td>
                                                                                                                           </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="companyDetail">
                                    	<form id="frmEditLoc" action="{{route('profile.company.update')}}" method="post">
                    					{{ csrf_field() }}
	                                    	<h6 class="text-success"><b>COMPANY INFORMATION</b></h6>
	                                    	<hr>
	                                    	<div class="container-fluid" id="detailsC">
		                                    	<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label class="text-muted" for="cname">Name <small class="text-success">*</small> :</label>
															<input type="text" id="cname" name="company_name" class="form-control" placeholder="Company name like: XYZ Corp Pvt Ltd" required value="{{ $user->company_name }}">
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label class="text-muted" for="creg">Registration No. <small class="text-success">*</small> :</label>
															<input type="text" id="creg" name="registration_number" class="form-control" placeholder="CIR-XXXXXX-XXXX" required value="{{ $user->registration_number }}">
														</div>
													</div>
{{--													<div class="col-sm-3">--}}
{{--														<div class="form-group">--}}
{{--															<label class="text-muted" for="cmark">Marketed By <small class="text-success">*</small> :</label>--}}
{{--															<input type="text" id="cmark" name="marketed_by" class="form-control" placeholder="Example Pvt Ltd" required value="{{ $user->marketed_by }}">--}}
{{--														</div>--}}
{{--													</div>--}}
		                                    	</div>

		                                    	<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label class="text-muted" for="cemail">Email <small class="text-success">*</small> :</label>
															<input type="email" id="cemail" name="company_email" class="form-control" placeholder="xyz@example.com" required value="{{ $user->company_email }}">
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label class="text-muted" for="cphone">Phone No. <small class="text-success">*</small> :</label>
															<input type="text" id="cphone" name="company_phone" class="form-control" placeholder="120114451145" required value="{{ $user->company_phone }}">
														</div>
													</div>
		                                    	</div>
		                                    	<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label class="text-muted" for="caddress">Address <small class="text-success">*</small> :</label>
															<textarea id="caddress" name="company_address" class="form-control" placeholder="" cols="25" rows="4" required>
																{{ $user->company_address }}
															</textarea>
														</div>
													</div>
		                                    	</div>
		                                    </div>


		                                    <br>
		                                    <h6 class="text-success"><b>CUSTOMER CARE INFORMATION</b></h6>
	                                    	<hr>
	                                    	<div class="container-fluid" id="detailsC">
		                                    	<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label class="text-muted" for="ccemail">Email Address<small class="text-success">*</small> :</label>
															<input type="email" id="ccemail" name="cc_email" class="form-control" placeholder="xyz@example.com" required value="{{ $user->cc_email }}">
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label class="text-muted" for="ccphone">Phone No. <small class="text-success">*</small> :</label>
															<input type="text" id="ccphone" name="cc_phone" class="form-control" placeholder="120114451145" required value="{{ $user->cc_phone }}">
														</div>
													</div>
		                                    	</div>
		                                    	<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label class="text-muted" for="ccaddress">Address <small class="text-success">*</small> :</label>
															<textarea id="ccaddress" name="cc_address" class="form-control" placeholder="" cols="25" rows="4" required>
																{{ $user->cc_address }}
															</textarea>
														</div>
													</div>
		                                    	</div>
		                                    </div>
		                                    <div class="container-fluid">
		                                    	<div class="row">
		                                    		<div class="col-sm-12">
		                                    			<input type="submit" name="submit" value="Update" class="btn btn-sm btn-success pull-right float-sm-right">
		                                    		</div>
		                                    	</div>
		                                    </div>

	                                    </form>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="manufacturer">
                                    	<div class="container-fluid">
							                <div class="row mb-2">
							                    <div class="col-sm-6">
							                        <h6 class="text-success"><b>Manufacturers</b></h6>
							                    </div>
							                    <div class="col-sm-6">
							                        <a abc="{{route('products.add')}}"  href="javascript:addNew()" class="btn btn-success btn-sm float-sm-right">+ Add New</a>
							                    </div>
							                </div>
							            </div>

							            <!-- <hr> -->
                                    	<div class="table-responsive">
	                                    	<table class="table projects" id="allManufacturer">
						                        <thead>
							                        <tr>
							                            <th style="width: 15%">
							                                Name
							                            </th>
{{--							                            <th style="width: 5%">--}}
{{--							                                Alias--}}
{{--							                            </th>--}}
							                            <th style="width: 20%">
							                                License No.
							                            </th>
							                            <th style="width: 20%">
							                                Address
							                            </th>
							                            <th style="width: 5%">
							                                Phone
							                            </th>
							                            <th style="width: 15%">
							                                City
							                            </th>
							                            <th style="width: 10%">
							                                State
							                            </th>
							                            <th style="width: 5%">
							                                Pincode
							                            </th>
							                            <th style="width: 5%">
							                                Action
							                            </th>
							                        </tr>
						                        </thead>
						                        <tbody>
						                            @if(!empty($manufacturers) && count($manufacturers) > 0)
						                            @foreach($manufacturers as $key => $manufacturer)
						                            <tr>
						                                <td style="text-transform: capitalize;">{{$manufacturer->m_name}}</td>
{{--						                                <td>{{$manufacturer->m_alias}}</td>--}}
						                                <td>{{$manufacturer->m_license}}</td>
						                                <td>{{$manufacturer->m_address}}</td>
						                                <td>{{$manufacturer->phone_no}}</td>
						                                <td>{{$manufacturer->city_name}}</td>
						                                <td>{{$manufacturer->state_name}}</td>
						                                <td>{{$manufacturer->m_pincode}}</td>
						                                <td><button onclick="EditM('{{$manufacturer->id}}')" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt mr-1" aria-hidden="true"></i></button></td>
						                            </tr>
						                            @endforeach
						                            @endif
						                        </tbody>
						                    </table>
						                </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="marketers">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <h6 class="text-success"><b>Marketers</b></h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <a abc="{{route('products.add')}}"  href="javascript:addNewMarketer()" class="btn btn-success btn-sm float-sm-right">+ Add New</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <hr> -->
                                        <div class="table-responsive">
                                            <table class="table projects" id="allManufacturer">
                                                <thead>
                                                <tr>
                                                    <th style="width: 15%">
                                                        Name
                                                    </th>
{{--                                                    <th style="width: 5%">--}}
{{--                                                        Alias--}}
{{--                                                    </th>--}}
{{--                                                    <th style="width: 20%">--}}
{{--                                                        License No.--}}
{{--                                                    </th>--}}
{{--                                                    <th style="width: 20%">--}}
{{--                                                        Address--}}
{{--                                                    </th>--}}
{{--                                                    <th style="width: 5%">--}}
{{--                                                        Phone--}}
{{--                                                    </th>--}}
{{--                                                    <th style="width: 15%">--}}
{{--                                                        City--}}
{{--                                                    </th>--}}
{{--                                                    <th style="width: 10%">--}}
{{--                                                        State--}}
{{--                                                    </th>--}}
{{--                                                    <th style="width: 5%">--}}
{{--                                                        Pincode--}}
{{--                                                    </th>--}}
{{--                                                    <th style="width: 5%">--}}
{{--                                                        Action--}}
{{--                                                    </th>--}}
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(!empty($marketers) && count($marketers) > 0)
                                                    @foreach($marketers as $key => $marketer)
                                                        <tr>
                                                            <td style="text-transform: capitalize;">{{$marketer->name}}</td>

                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="changePassword">
                                        <form id="frmEditLoc" action="{{route('changePasswordStore')}}" method="post">
                    					{{ csrf_field() }}
	                                    	<h6 class="text-success"><b>Change Password</b></h6>
	                                    	<hr>
	                                    	<div class="container-fluid">
		                                    	<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label class="text-muted" for="current_password">Current Password <small class="text-success">*</small> :</label>
															<input type="password" id="current_password" name="current_password" class="form-control" required>
														</div>
													</div>

		                                    	</div>
		                                    	<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label class="text-muted" for="new_password">New Password <small class="text-success">*</small> :</label>
															<input type="password" id="new_password" name="new_password" class="form-control" required>
														</div>
													</div>
		                                    	</div>
		                                    	<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label class="text-muted" for="confirm_password">Confirm Password <small class="text-success">*</small> :</label>
															<input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
														</div>
													</div>
		                                    	</div>
		                                    </div>
		                                    <div class="container-fluid">
		                                    	<div class="row">
		                                    		<div class="col-sm-12">
		                                    			<input type="submit" name="submit" value="Update" class="btn btn-sm btn-success pull-right float-sm-right">
		                                    		</div>
		                                    	</div>
		                                    </div>

	                                    </form>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>




    <div class="modal fade" id="modalNewManufacturer" tabindex="-1" role="dialog" aria-labelledby="lblTitleEdit">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="lblTitleEdit">Create New Manufacturer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="frmEditLoc" action="{{route('profileManufacturersAdd')}}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="m_name" class="text-muted">Name <small class="text-success">*</small> :</label>
                                        <input id="m_name" type="text" name="m_name" class="form-control" required >
                                    </div>
                                </div>
{{--                                <div class="col-md-3">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="m_alias" class="text-muted">Unique Alias Name <small class="text-success">*</small> :</label>--}}
{{--                                        <input id="m_alias" type="text" name="m_alias" class="form-control" required >--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="m_license" class="text-muted">License No. <small class="text-success">*</small> :</label>
                                        <input id="m_license" type="text" name="m_license" class="form-control" required >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone_no" class="text-muted">Phone No. <small class="text-success">*</small> :</label>
                                        <input id="phone_no" type="number" name="phone_no" class="form-control" required >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="state_id" class="text-muted">State <small class="text-success">*</small> :</label>
                                        <select class="form-control" name="state_id" id="state_id">
                                        	<option value="null">-select state-</option>
                                        	@foreach($states as $key => $state)
                                        	<option value="{{$key}}">{{$state}}</option>
                                        	@endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="city_name" class="text-muted">City <small class="text-success">*</small> :</label>
                                        <input id="city_name" type="text" name="city_name" class="form-control" required >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="m_address" class="text-muted">Address <small class="text-success">*</small> :</label>
                                        <textarea id="m_address" name="m_address" class="form-control" cols="
                                        25" rows="5" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="m_pincode" class="text-muted">Pincode <small class="text-success">*</small> :</label>
                                        <input id="m_pincode" type="text" name="m_pincode" class="form-control" required >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" class="btn btn-success">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNewMarketers" tabindex="-1" role="dialog" aria-labelledby="lblTitleEdit">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="lblTitleEdit">Create New Marketer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="frmEditLoc" action="{{route('profileMarketerAdd')}}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="m_name" class="text-muted">Name <small class="text-success">*</small> :</label>
                                        <input id="mar_name" type="text" name="name" class="form-control" required >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" class="btn btn-success">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditManufacturer" tabindex="-1" role="dialog" aria-labelledby="lblTitleEdit">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="lblTitleEdit">Update Manufacturer Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="frmEditManufacture" action="{{route('profileManufacturersUpdate')}}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="manId" value="">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="m_name" class="text-muted">Name <small class="text-success">*</small> :</label>
                                        <input id="e_m_name" type="text" name="m_name" class="form-control" required >
                                    </div>
                                </div>
{{--                                <div class="col-md-3">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="m_alias" class="text-muted">Unique Alias Name <small class="text-success">*</small> :</label>--}}
{{--                                        <input id="e_m_alias" type="text" name="m_alias" class="form-control" required disabled>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="m_license" class="text-muted">License No. <small class="text-success">*</small> :</label>
                                        <input id="e_m_license" type="text" name="m_license" class="form-control" required >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone_no" class="text-muted">Phone No. <small class="text-success">*</small> :</label>
                                        <input id="e_phone_no" type="number" name="phone_no" class="form-control" required >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="state_id" class="text-muted">State <small class="text-success">*</small> :</label>
                                        <select class="form-control" name="state_id" id="e_state_id">
                                        	<option value="null">-select state-</option>
                                        	@foreach($states as $key => $state)
                                        	<option value="{{$key}}">{{$state}}</option>
                                        	@endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="city_name" class="text-muted">City <small class="text-success">*</small> :</label>
                                        <input id="e_city_name" type="text" name="city_name" class="form-control" required >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="m_address" class="text-muted">Address <small class="text-success">*</small> :</label>
                                        <textarea id="e_m_address" name="m_address" class="form-control" cols="
                                        25" rows="5" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="m_pincode" class="text-muted">Pincode <small class="text-success">*</small> :</label>
                                        <input id="e_m_pincode" type="text" name="m_pincode" class="form-control" required >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Update" class="btn btn-success">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">

    function addNew() {
        $("#modalNewManufacturer").modal("show");
    }

    function addNewMarketer() {
        $("#modalNewMarketers").modal("show");
    }

    function EditM(id) {
    	$('#manId').val(id);
    	// Get the user details
        var jqxhr = $.ajax({
            url: "/profile-manufacturer-get/" + id,
            type: "GET",
            dataType: "json"
        });

        // Insert retrieved details into form inputs
        jqxhr.done(function (data, textStatus, jqXHR) {
            $("#e_m_name").val(data.manufacturer.m_name);
            //$("#e_m_alias").val(data.manufacturer.m_alias);
            $("#e_m_license").val(data.manufacturer.m_license);
            $("#e_phone_no").val(data.manufacturer.phone_no);
            $("#e_state_id").val(data.manufacturer.state_id);
            $("#e_city_name").val(data.manufacturer.city_name);
            $("#e_m_address").val(data.manufacturer.m_address);
            $("#e_m_pincode").val(data.manufacturer.m_pincode);



            $("#modalEditManufacturer").modal("show");
        });

    }

    $(document).ready(function () {
      var table = $('#allManufacturer').DataTable({
        pagingType: "simple_numbers",
        "language": {
                "lengthMenu": '_MENU_ rows per page',
                    "search": '<i class="fa fa-search"></i>',
                    "searchPlaceholder": "Search",
                    "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i> Previous',
                        "next": 'Next <i class="fa fa-angle-right"></i>'
                }
            }
      });
    });
</script>
@endsection
