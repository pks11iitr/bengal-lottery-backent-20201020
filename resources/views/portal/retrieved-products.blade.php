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
                        <h1>Products</h1>
                    </div>
                    <div class="col-sm-6">
                        <a abc="{{route('products.add')}}"  href="javascript:addNew()" class="btn btn-info btn-sm float-sm-right">+ Add New</a>
                        <a href="{{route('website.home')}}/plugin.zip" class="btn btn-info btn-sm float-sm-right" style="margin-right: 20px;">Download Syncing Plugin</a>
                        <a href="{{route('website.home')}}/how-it-works.docx" class="btn btn-info btn-sm float-sm-right" style="margin-right: 20px;">How To Sync Data</a>
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
                            <th style="width: 30%">
                                Product Name
                            </th>
                            <th style="width: 5%">
                                License
                            </th>
{{--                            <th style="width: 5%">--}}
{{--                                Caution--}}
{{--                            </th>--}}
{{--                            <th style="width: 20%">--}}
{{--                                SKU--}}
{{--                            </th>--}}
{{--                            <th style="width: 9%" class="text-center">--}}
{{--                                Status--}}
{{--                            </th>--}}
                            <th style="width: 20%">
                            </th>
                        </tr>
                        </thead>
                        <tbody>


                        <!-- <tr>
                            <td>
                                #
                            </td>
                            <td>
                                <a>
                                    AdminLTE v3
                                </a>
                                <br/>
                                <small>
                                    Created 01.01.2019
                                </small>
                            </td>
                            <td>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <img alt="Avatar" class="table-avatar" src="{{asset('portal/img/avatar.png')}}">
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <img alt="Avatar" class="table-avatar" src="{{asset('portal/img/avatar.png')}}">
                                    </li>
                                </ul>
                            </td>
                            <td class="project_progress">
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-green" role="progressbar" aria-volumenow="57" aria-volumemin="0" aria-volumemax="100" style="width: 57%">
                                    </div>
                                </div>
                                <small>
                                    57% Complete
                                </small>
                            </td>
                            <td class="project-state">
                                <span class="badge badge-success">Success</span>
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="#">
                                    <i class="fas fa-folder">
                                    </i>
                                    View
                                </a>
                                <a class="btn btn-danger btn-sm" href="#">
                                    <i class="fas fa-trash">
                                    </i>
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <tr> -->

                        @if(!empty($products) && count($products) > 0)
                            @foreach($products as $key => $product)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td style="text-transform: capitalize;">
                                        {{$product['product_name']}}
                                    </td>
                                    <td>{{$product['license']}}</td>

                                    <td class="project-actions text-right">
                                        <a class="btn btn-primary btn-sm" href="javascript:editProduct({{$product['id']}})" title="Edit">
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
                    <h4 class="modal-title" id="lblTitleEdit">Create New Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="frmEditLoc" action="{{route('products.addRtrvStore')}}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_name" class="text-muted">Product Name <small class="text-success">*</small> :</label>
                                        <input id="product_name" type="text" name="product_name" class="form-control" required >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="license" class="text-muted">Registration No. <small class="text-success">*</small> :</label>
                                        <input id="license" type="text" name="license" class="form-control" required >
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

    <div class="modal fade" id="modalEditProduct" tabindex="-1" role="dialog" aria-labelledby="lblTitleEdit">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="lblTitleEdit">Edit Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="frmEditLoc" action="{{route('products.editRtrvUpdate')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" value="" id="productIdEdit">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code" class="text-muted">Product Name <small class="text-success">*</small> :</label>
                                        <input id="product_name_edit" type="text" name="product_name" class="form-control" required >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="license" class="text-muted">Registration No. <small class="text-success">*</small> :</label>
                                        <input id="license_edit" type="text" name="license" class="form-control" required >
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">

        function addNew() {
            $("#modalNewProduct").modal("show");
        }

        function editProduct(productId) {
            if(productId != 0) {
                $.ajax({
                  url: "{{route('retrieveProductDetailAjax')}}",
                  dataType: "json",
                  data: {
                    id: productId
                  },
                  success: function( data ) {
                    var productData = data.returnData;
                    $('#productIdEdit').val(productData.id);
                    $('#product_name_edit').val(productData.product_name);
                    $('#license_edit').val(productData.license);
                  }
                });
                $("#modalEditProduct").modal("show");
            }
        }
    </script>
@endsection
