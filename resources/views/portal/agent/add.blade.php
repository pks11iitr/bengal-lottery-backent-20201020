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
                        <h1>Agents</h1>
                    </div>
                    <div class="col-sm-6">
                        <a abc="{{route('products.add')}}"  href="javascript:addNew()" class="btn btn-info btn-sm float-sm-right">+ Add New</a>
                    </div>
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
                                Account
                            </th>
                            <th style="width: 15%">
                               Name
                            </th>
                            <th style="width: 15%">
                                Parent Name
                            </th>
                            <th style="width: 15%">
                                Balance
                            </th>
                            <th style="width: 10%">
                                Deposit
                            </th>
                            <th style="width: 15%">
                                Withdraw
                            </th>
                            <th style="width: 25%">
                                Status
                            </th>
                            <!-- <th style="width: 9%" class="text-center">
                                Size
                            </th> -->
                            <th style="width: 10%; text-align: right">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($agents) && count($agents) > 0)
                            @foreach($agents as $key => $product)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td style="text-transform: capitalize;">
                                       {{$product->account?:'MAIN AGENT'}}
                                    </td>
                                    <td style="text-transform: capitalize;">
                                        {{$product->email}}
                                    </td>
                                    <td style="text-transform: capitalize;">
                                        {{$product->agent->email}}
                                    </td>
                                    <td style="text-transform: capitalize;">
                                        {{$product->balance}}
                                    </td>
                                    <td style="text-transform: capitalize;">
                                        {{$product->totaldeposit}}
                                    </td>
                                    <td style="text-transform: capitalize;">
                                        {{$product->totalwithdraw}}
                                    </td>
                                    <td style="text-transform: capitalize;">
                                        @if($product->status==1){{'Active'}}@elseif($product->status==0){{'Inactive'}}@else{{'Blocked'}}@endif
                                    </td>


                                    <td class="project-actions text-right">
                                        <a class="btn btn-primary btn-sm" href="javascript:editProduct({{$product->id}})" title="Edit">
                                            <i class="fas fa-pencil-alt mr-1" aria-hidden="true"></i>
                                        </a>
                                        <!-- <a class="btn btn-danger btn-sm" href="#">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </a> -->
                                    </td>
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


    <div class="modal fade" id="modalNewProduct" tabindex="-1" role="dialog" aria-labelledby="lblTitleEdit">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="lblTitleEdit">Create New Agent</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="frmEditLoc" action="{{route('agentcreate')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branch_name" class="text-muted">Username <small class="text-success">*</small> :</label>
                                        <input id="username" type="text" name="username" class="form-control" required >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code" class="text-muted">Password <small class="text-success">*</small> :</label>
                                        <input id="password" type="text" name="password" class="form-control" required >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code" class="text-muted">Confirm Password <small class="text-success">*</small> :</label>
                                        <input id="cpassword" type="text" name="cpassword" class="form-control" required >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Isactive</label>
                                        <select class="form-control select2" id="status" name="status">
                                            <option value="">Please Select Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                            <option value="2">Blocked</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>

{{--                            <div class="row">--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="license" class="text-muted">Registration No. <small class="text-success">*</small> :</label>--}}
{{--                                        <input id="license" type="text" name="license" class="form-control" required >--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="sku" class="text-muted">Product Code <small class="text-success">*</small> :</label>--}}
{{--                                        <input id="sku" type="text" name="sku" class="form-control" required >--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="row">--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="sku_size" class="text-muted">Pack Size <small class="text-success">*</small> :</label>--}}
{{--                                        <input id="sku_size" type="text" name="sku_size" class="form-control" required >--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="txtProductImage" class="text-muted">Product Image <small class="text-success">*</small> :</label>--}}
{{--                                        <input id="txtProductImage" type="file" name="product_image" accept="image/*" class="form-control selectImg btn btn-info">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="antidote_statement" class="text-muted">Antidote Statement <small class="text-success">*</small> :</label>--}}
{{--                                        <textarea id="antidote_statement" name="antidote_statement" class="form-control" cols="50" rows="4" required>In case of poisoning, contact a doctor immediately and show the can for ingredient details. Treat symptomatically.</textarea>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row">--}}

{{--                                <div class="col-md-12">--}}

{{--                                    <div class="form-group">--}}
{{--                                        <label for="cautionselect" class="text-muted">Caution Logo <small class="text-success">*</small> :</label>--}}
{{--                                        <br>--}}
{{--                                        <span style="margin-right: 10px;">--}}
{{--                                            <input id="caution1" type="radio" name="caution_id" class="filled-in chk-col-purple" value="1">--}}
{{--                                            <img src="/caution-images/1.jpg" width="150" style="border-radius: 2%;">--}}
{{--                                        </span>--}}

{{--                                        <span style="margin-right: 10px;">--}}
{{--                                            <input id="caution1" type="radio" name="caution_id" class="filled-in chk-col-purple" value="2">--}}
{{--                                            <img src="/caution-images/2.jpg" width="150" style="border-radius: 2%;">--}}
{{--                                        </span>--}}

{{--                                        <span style="margin-right: 10px;">--}}
{{--                                            <input id="caution1" type="radio" name="caution_id" class="filled-in chk-col-purple" value="3">--}}
{{--                                            <img src="/caution-images/3.jpg" width="150" style="border-radius: 2%;">--}}
{{--                                        </span>--}}
{{--                                        <span>--}}
{{--                                            <input id="caution1" type="radio" name="caution_id" class="filled-in chk-col-purple" value="3">--}}
{{--                                            <img src="/caution-images/4.jpg" width="150" style="border-radius:2%;">--}}
{{--                                        </span>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}


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

    <div class="modal fade" id="modalEditProduct" tabindex="-1" role="dialog" aria-labelledby="lblTitleEdit">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="lblTitleEdit">Update Agent Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="frmEditLoc" action="{{route('agentupdate')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="agent_id" value="" id="productIdEdit">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username" class="text-muted"> <small class="text-success">*</small> Agent:</label>
                                        <input id="username_edit" type="text" name="username_edit" class="form-control" readonly >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code" class="text-muted">Deposit<small class="text-success">*</small> :</label>
                                        <input id="deposit_edit" type="text" name="deposit_edit" class="form-control" required >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code" class="text-muted">Withdraw<small class="text-success">*</small> :</label>
                                        <input id="withdraw_edit" type="text" name="withdraw_edit" class="form-control" required >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Isactive</label>
                                        <select class="form-control select2" id="status_edit" name="status_edit">
                                            <option value="">Please Select Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                            <option value="2">Blocked</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">

        function addNew() {
            $("#modalNewProduct").modal("show");
        }

        function editProduct(productId) {
            if(productId != 0) {
                $.ajax({
                    url: "{{route('agentdetails')}}",
                    dataType: "json",
                    data: {
                        id: productId
                    },
                    success: function( data ) {
                        var productData = data.returnData;
                        $('#productIdEdit').val(productData.id);
                        $('#username_edit').val(productData.email);
                        $('#deposit_edit').val(productData.deposit);
                        $('#status_edit').val(productData.status);
                        $('#withdraw_edit').val(productData.withdraw);

                        // $('#caution'+productData.caution_id+'_edit').prop('checked', true);
                    }
                });
                $("#modalEditProduct").modal("show");
            }
        }

        $(document).ready(function () {
            var table = $('#allProducts').DataTable({
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
        $(document).ready(function () {
            $('#product_name').autocomplete({

                source: function( request, response ) {
                    $.ajax({
                        url: "{{route('productSearch')}}",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
                        success: function( data ) {
                            console.log(data.returnData);
                            response($.map(data.returnData, function (item) {
                                return {
                                    label: item.label,
                                    value: item.value,
                                    category : item.category
                                };
                            }));
                        }
                    });
                },
                focus: function( event, ui ) {
                    $( "#product_name" ).val( ui.item.label );
                    return false;
                },
                minLength: 2,
                select: function( event, ui ) {
                    $('#product_name').val(this.value);
                }
            });

            $( "#product_name" ).autocomplete( "option", "appendTo", "#modalNewProduct" );
        });

        $(document).ready(function () {
            $('#product_name_edit').autocomplete({

                source: function( request, response ) {
                    $.ajax({
                        url: "{{route('productSearch')}}",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
                        success: function( data ) {
                            console.log(data.returnData);
                            response($.map(data.returnData, function (item) {
                                return {
                                    label: item.label,
                                    value: item.value,
                                    category : item.category
                                };
                            }));
                        }
                    });
                },
                focus: function( event, ui ) {
                    $( "#product_name_edit" ).val( ui.item.label );
                    return false;
                },
                minLength: 2,
                select: function( event, ui ) {
                    $('#product_name_edit').val(this.value);
                }
            });

            $( "#product_name_edit" ).autocomplete( "option", "appendTo", "#modalEditProduct" );
        });

        $('#license').autocomplete({

            source: function( request, response ) {
                $.ajax({
                    url: "{{route('productSearchLicense')}}",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function( data ) {
                        console.log(data.returnData);
                        response($.map(data.returnData, function (item) {
                            return {
                                label: item.label,
                                value: item.value
                            };
                        }));
                    }
                });
            },
            minLength: 3,
            select: function( event, ui ) {
                $('#license').val(this.value);

            },
            open: function() {
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });

        $( "#license" ).autocomplete( "option", "appendTo", "#modalNewProduct" );

        $('#license_edit').autocomplete({

            source: function( request, response ) {
                $.ajax({
                    url: "{{route('productSearchLicense')}}",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function( data ) {
                        console.log(data.returnData);
                        response($.map(data.returnData, function (item) {
                            return {
                                label: item.label,
                                value: item.value
                            };
                        }));
                    }
                });
            },
            minLength: 3,
            select: function( event, ui ) {
                $('#license_edit').val(this.value);

            },
            open: function() {
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });

        $( "#license_edit" ).autocomplete( "option", "appendTo", "#modalEditProduct" );




    </script>
@endsection
