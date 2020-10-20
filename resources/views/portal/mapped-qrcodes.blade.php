@extends('layouts.portal-layout')

@section('content')

<style type="text/css">
	.mr-10 {
		margin-right: 10px;
	}
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
                    <div class="col-sm-4">
                        <h1>Mapped QR Codes</h1>
                    </div>
                    <div class="col-sm-8">
                        <a href="javascript:viewCode()" class="btn btn-info btn-sm float-sm-right">Generate Blank Codes</a>
                        <a href="javascript:preMapSku()" class="btn btn-info btn-sm float-sm-right mr-10">Quick Generate & Map</a>
                        <a href="javascript:mapSku()" class="btn btn-info btn-sm float-sm-right mr-10">Map QR Codes</a>
                        <a href="{{route('mapped.codes')}}" class="btn btn-info btn-sm float-sm-right mr-10">Mapped Codes</a>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
{{--                    <h3 class="card-title">Products</h3>--}}

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 1%">
                                Product Name
                            </th>
                            <th style="width: 30%">
                                Start Sequence
                            </th>
                            <th style="width: 30%">
                                End Sequence
                            </th>
                            <th style="width: 5%">
                                Total
                            </th>
                            <th style="width: 20%">
                                Manufacturer
                            </th>
                            <th style="width: 9%" class="text-center">
                                Marketer
                            </th>
                            <th style="width: 9%" class="text-center">
                                Time
                            </th>
                            <th style="width: 9%" class="text-center">
                                Status
                            </th>
                            <th style="width: 20%">
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($codes as $code)
                        <tr>
                            <td>
                                {{$code->product->name??''}}
                                {{$code->product->brand_name??''}}
                                {{($code->product->sku??'').' '.($code->product->sku_size??'')}}

                            </td>
                            <td>
								{{$code->printFormat($code->sequence_start)}}
                            </td>
                            <td>
                                {{$code->printFormat($code->sequence_end)}}
                            </td>
                            <td class="project_progress">
                                <small>
                                    {{$code->total}}
                                </small>
                            </td>
                            <td class="project_progress">
                                <small>
                                    {{$code->manufacturer->m_name??''}}
                                </small>
                            </td>
                            <td class="project_progress">
                                <small>
                                    {{$code->marketer->name??''}}
                                </small>
                            </td>
                            <td>
                                {{date('d M Y', strtotime($code->created_at))}}<br>{{date('h:i A', strtotime($code->created_at))}}
                            </td>
                            <td class="project-state">
                                @if($code->can_be_unmapped)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-error">Expired</span>
                                @endif
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{$code->file_path}}">
                                    Download
                                </a>
                            </td>
                        </tr>
                        @endforeach
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



<div class="modal fade" id="viewCodeModal" tabindex="-1" role="dialog" aria-labelledby="lblTitleEdit">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-success" id="lblTitleEdit">Generate Blank Codes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form id="generate-form" action="" method="post" enctype="multipart/form-data" onsubmit="return generate()">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="code" class="text-muted">Enter Number Of Code You Want To Generate:<small class="text-success">*</small> :</label>
                                    <input id="qr_code" type="number" name="count" class="form-control" min="1" max="1000000" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                	<label for="code" class="text-muted" style="height: 100%;width: 100%;">&nbsp;</label>
                                    <input type="submit" value="Generate" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="preMapSKUModal" tabindex="-1" role="dialog" aria-labelledby="lblTitleEdit">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-success" id="lblTitleEdit">Quick Generate Codes For Products</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form id="generate-n-map-form" action="{{route('qrcodes.generate.map')}}" method="post" enctype="multipart/form-data" onsubmit="return generateNMap()">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-muted">Fill Required Information</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code" class="text-muted">Product <small class="text-success">*</small> :</label>
                                    <select class="form-control" required name="product_id" required>
                                        <option value="">--Select Product--</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name.'('.$product->sku.'-'.$product->sku_size.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="license" class="text-muted">Manufacturer <small class="text-success">*</small> :</label>
                                    <select class="form-control" required name="manufacturer_id" required>
                                        <option value="">--Select Manufacturer--</option>
                                        @foreach($manufacturers as $manufacturer)
                                            <option value="{{$manufacturer->id}}">{{$manufacturer->m_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="license" class="text-muted">Marketer <small class="text-success">*</small> :</label>
                                    <select class="form-control" required name="marketer_id" required>
                                        <option value="">--Select Marketer--</option>
                                        @foreach($marketers as $marketer)
                                            <option value="{{$marketer->id}}">{{$marketer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="batch" class="text-muted">Batch No. <small class="text-success">*</small> :</label>
                                    <input id="batch" type="text" name="batch_number" class="form-control" required placeholder="Enter product batch number" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="mfgdate" class="text-muted">Mfg. Date <small class="text-success">*</small> :</label>
                                    <input id="mfgdate" type="date" name="mfg_date" class="form-control" required >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="expdate" class="text-muted">Exp. Date <small class="text-success">*</small> :</label>
                                    <input id="expdate" type="date" name="exp_date" class="form-control" required >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_qr" class="text-muted">Total QR Codes <small class="text-success">*</small> :</label>
                                    <input type="number" id="total_qr" name="count" class="form-control" required placeholder="Enter total number of QR code required" min="1" max="1000000">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Map Codes" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="mapSKUModal" tabindex="-1" role="dialog" aria-labelledby="lblTitleEdit">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-success" id="lblTitleEdit">Map QR Codes & Products</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form id="code-map-form" action="{{route('qrcodes.map')}}" method="post" enctype="multipart/form-data" onsubmit="return mapCode()">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-muted">Fill Required Information</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code" class="text-muted">Product <small class="text-success">*</small> :</label>
                                    <select class="form-control" required name="product_id">
                                        <option value="">--Select Product--</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name.'('.$product->sku.'-'.$product->sku_size.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="license" class="text-muted">Manufacturer <small class="text-success">*</small> :</label>
                                    <select class="form-control" required name="manufacturer_id">
                                        <option value="">--Select Manufacturer--</option>
                                        @foreach($manufacturers as $manufacturer)
                                            <option value="{{$manufacturer->id}}">{{$manufacturer->m_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="license" class="text-muted">Marketer <small class="text-success">*</small> :</label>
                                    <select class="form-control" required name="marketer_id" required>
                                        <option value="">--Select Marketer--</option>
                                        @foreach($marketers as $marketer)
                                            <option value="{{$marketer->id}}">{{$marketer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="batch" class="text-muted">Batch No. <small class="text-success">*</small> :</label>
                                    <input id="batch" type="text" name="batch_number" class="form-control" required placeholder="Enter product batch number">
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="mfgdate" class="text-muted">Mfg. Date <small class="text-success">*</small> :</label>
                                    <input id="mfgdate" type="date" name="mfg_date" class="form-control" required >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="expdate" class="text-muted">Exp. Date <small class="text-success">*</small> :</label>
                                    <input id="expdate" type="date" name="exp_date" class="form-control" required >
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_code" class="text-muted">Start Code Sequence <small class="text-success">*</small> :</label>
                                    <input type="text" id="start_code" name="start_code" class="form-control" required placeholder="Enter start unique code">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_code" class="text-muted">End Code Sequence <small class="text-success">*</small> :</label>
                                    <input type="text" id="end_code" name="end_code" class="form-control" required placeholder="Enter end unique code">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Map Codes" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
</div>



@endsection






@section('scripts')
<script type="text/javascript">
    function viewCode() {
        $("#viewCodeModal").modal("show");
    }

    function preMapSku() {
        $("#preMapSKUModal").modal("show");
    }

    function mapSku() {
        $("#mapSKUModal").modal("show");
    }

    function generate(){

        $.ajax({

            url:'{{route('qrcodes.generate')}}',
            data:$('#generate-form').serialize(),
            method:'post',
            datatype: 'json',
            success:function(data){

                if(data.status=='success'){
                    location.reload();
                }else{
                    alert(data.message)
                }


            }

        })

        return false
    }

    function generateNMap(){

        $.ajax({

            url:'{{route('qrcodes.generate.map')}}',
            data:$('#generate-n-map-form').serialize(),
            method:'post',
            datatype: 'json',
            success:function(data){

                if(data.status=='success'){
                    location.reload();
                }else{
                    alert(data.message)
                }


            }

        })

        return false
    }

</script>
@endsection
