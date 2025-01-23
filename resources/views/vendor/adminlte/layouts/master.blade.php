@extends('adminlte::page')
@section('javascript')
<script src="{{ asset('/js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('js/dataTables.dataTables.min.js')}}"></script>
<script type="text/javascript">
	$(".sidebar-toggle").click();
	$(".select2").select2();
    var tbl_data = $("#tDatos").DataTable();
    function statusLabelOnGrid(statusValue) {
    	switch (parseInt(statusValue)) {
            case 1:
                return "<span class='label label-success'>Activo</span>";
                break;
            case 0:
                return "<span class='label label-danger'>Inactivo</span>";
                break;
            default:
            	break;
        }
    };
    function htmlMasterButton(aData) {
    	let btn = "";
            btn+="<button class='btn btn-primary prepare btn-sm' data-target='#mdlStore' data-toggle='modal' ";
            btn+=" data-id='"+aData['id']+"' style='margin-right: 5px;'>";
            btn+="<i class='fa fa-pencil'></i>";
            btn+="</button>";
            btn += '<button class="btn btn-danger btn-sm destroy">';
            btn += '<i class="fa fa-trash"></i>';
        btn += '</button>';

        return btn;
    };
    function isVisible(flagVisible) {
        switch (parseInt(flagVisible)) {
            case 1:
                return "<span class='label label-success'>SÍ</span>";
                break;
            case 0:
                return "<span class='label label-danger'>NO</span>";
                break;
            default:
                break;
        }
    }
</script>
@endsection
@section("stylesheet")
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/jconfirm/jquery-confirm.min.css') }}">
@stack("custom_css")
@endsection


@section('main-content')
<div class="container-fluid spark-screen">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">

            <div class="box box-solid">
                <div class="box-header with-border box-primary">
                    <h3 class="box-title">
                    	@yield("title_view_master_template")
                    </h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary" id="btnAdd">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;{{ trans("view.button.new") }}
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                @yield("custom_filters")
            </div>
            <div class="box box-solid">
            	@yield("custom_master_section")
                <div class="box-body table-responsive" id="tableResponsive">
                    <div class="table-responsive-md">
                        <table class="table table-hover table-striped" id="tDatos" style="width:100%">
                            <thead>
                            	@stack("grid_columns_master")
                                
                                </thead>
                                <tbody>

                                </tbody>
                        </table>
                    </div>    
                </div>
                    <div class="box-footer">
                        
                    </div>
                    <!-- /.box-body -->
            </div>
        </div>
    </div>
</div>
@stack("modals_master")
@endsection