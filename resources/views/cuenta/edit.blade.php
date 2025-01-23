@extends('adminlte::layouts.app')

@section('contentheader_title')
	<i class="fa fa-home"></i> Inicio
@endsection
@section('htmlheader_title')
	Inicio
@endsection
@section('contentheader_description')

@endsection
@section('contentheader_breadcrumb')
	<ol class="breadcrumb">
		{{--<li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>--}}
		<li class="active"><i class="fa fa-dashboard"></i> Inicio</li>
	</ol>
@endsection
@section('jquery')
	<script type="text/javascript">
		$('#men-home').addClass('active');
	</script>
@endsection


@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">

				<!-- Default box -->
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Home</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
								<i class="fa fa-times"></i></button>
						</div>
					</div>
					<div class="box-body">
						{{ trans('adminlte_lang::message.logged') }}. Start creating your amazing application!
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->

			</div>
		</div>
	</div>
@endsection
