@extends('layouts.portal-layout')

@section('content')

<style type="text/css">
    .br-lft {border-left: 1px solid #c5c5c5;}
    .pd-lft-5 {padding-left: 5px;}
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
                    <div class="col-sm-12">
                        <h1>Product Details</h1>
                        <label>{{$code1->product->name??''}}</label>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4" style="padding: 0px 15px;">
                                <img src="{{$code1->product->image??''}}" style="border-radius: 1px;width: 100%;height: 100%;">
                            </div>
                            <div class="col-md-8 br-lft">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>{{$code1->product->name??''}}</h4>
                                            <span class="text-muted">Category:Pesticide</span>
                                            <strong class="text-muted">&nbsp;|</strong>
                                            <span class="text-muted pd-lft-5">Expiry On:{{$code1->expiry_date?date('d/m/y', strtotime($code1->expiry_date)):''}}</span>
                                            <strong class="text-muted">&nbsp;|</strong>
                                            <span class="text-muted pd-lft-5">Mfg Date:{{$code1->manufactured_date?date('d/m/y', strtotime($code1->manufactured_date)):''}}</span>
                                            <br><br>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6 class=""><strong>Description</strong></h6>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    Manufacturer Name
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    :
                                                </div>
                                                <div class="col-md-7">
                                                    {{$code1->manufacturer->m_name??''}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    Product Registration No.
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    :
                                                </div>
                                                <div class="col-md-7">
                                                    {{$code1->product->license??''}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    Date of Manufaturing
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    :
                                                </div>
                                                <div class="col-md-7">
                                                    {{$code1->manufactured_date?date('d/m/y', strtotime($code1->manufactured_date)):''}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    Expiry Date
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    :
                                                </div>
                                                <div class="col-md-7">
                                                    {{$code1->expiry_date?date('d/m/y', strtotime($code1->expiry_date)):''}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    Product Name
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    :
                                                </div>
                                                <div class="col-md-7">
                                                    {{$code1->product->name??''}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    Unique Code
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    :
                                                </div>
                                                <div class="col-md-7">
                                                    {{$unique_code}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    Manufacturer License No.
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    :
                                                </div>
                                                <div class="col-md-7">
                                                    {{$code1->manufacturer->m_license??''}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    Marketed By
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    :
                                                </div>
                                                <div class="col-md-7">
                                                    {{$code1->marketer->name??''}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    AntiTode Statement
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    :
                                                </div>
                                                <div class="col-md-7">
                                                    {{$code1->product->antidote_statement??''}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <img src="/caution-images/{{$code1->product->caution_id??''}}.jpg" width="50" style="border-radius: 1px;">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6 class=""><strong>Customer Care</strong></h6>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    Email Address
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    :
                                                </div>
                                                <div class="col-md-7">
                                                    {{$user->cc_email}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    Phone No.
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    :
                                                </div>
                                                <div class="col-md-7">
                                                    {{$user->cc_phone}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    Address
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    :
                                                </div>
                                                <div class="col-md-7">
                                                    {{$user->cc_address}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                <form id="frmEditLoc" action="{{route('products.addStore')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code" class="text-muted">Product Name <small class="text-success">*</small> :</label>
                                        <input id="product_name" type="text" name="name" class="form-control" required >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="license" class="text-muted">Registration No. <small class="text-success">*</small> :</label>
                                        <input id="license" type="text" name="license" class="form-control" required >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sku" class="text-muted">SKU ID <small class="text-success">*</small> :</label>
                                        <input id="sku" type="text" name="sku" class="form-control" required >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sku_size" class="text-muted">SKU Size <small class="text-success">*</small> :</label>
                                        <input id="sku_size" type="text" name="sku_size" class="form-control" required >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="antidote_statement" class="text-muted">Antidote Statement <small class="text-success">*</small> :</label>
                                        <textarea id="antidote_statement" name="antidote_statement" class="form-control" cols="50" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="cautionselect" class="text-muted">Caution Logo <small class="text-success">*</small> :</label>
                                        <br>
                                        <span>
                                            <input id="caution1" type="radio" name="caution_id" class="filled-in chk-col-purple" value="1">
                                            <img src="/caution-images/1.png" width="50" style="border-radius: 1px;">
                                        </span>

                                        <span>
                                            <input id="caution1" type="radio" name="caution_id" class="filled-in chk-col-purple" value="2">
                                            <img src="/caution-images/2.png" width="50" style="border-radius: 1px;">
                                        </span>

                                        <span>
                                            <input id="caution1" type="radio" name="caution_id" class="filled-in chk-col-purple" value="3">
                                            <img src="/caution-images/3.png" width="50" style="border-radius: 1px;">
                                        </span>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtProductImage" class="text-muted">Product Image <small class="text-success">*</small> :</label>
                                        <input id="txtProductImage" type="file" name="product_image" accept="image/*" class="form-control selectImg btn btn-info">
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



@endsection



@section('scripts')
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">

    function addNew() {
        $("#modalNewProduct").modal("show");
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

        $.widget( "custom.catcomplete", $.ui.autocomplete, {
            _renderMenu: function( ul, items ) {
                var self = this, currentCategory = "";
                $.each( items, function( index, item ) {
                    if ( item.category != currentCategory ) {
                        ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                        currentCategory = item.category;
                    }
                    self._renderItem( ul, item );
                });
            }
        });
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




</script>
@endsection
