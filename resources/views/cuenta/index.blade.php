@extends('adminlte::layouts.app')

@section('contentheader_title')
	<i class="fa fa-address-card-o"></i> Cuenta DNI
@endsection
@section('htmlheader_title')
	Cuenta DNI
@endsection
@section('contentheader_description')

@endsection
@section('contentheader_breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Operadores</a></li>
		<li class="active"><i class="fa fa-dashboard"></i> Cuenta DNI</li>
	</ol>
@endsection
@section('jquery')
	<script type="text/javascript">
		$('#men-oper, #men-oper-dni').addClass('active');
	</script>
@endsection


@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">

				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Cuenta</h3>
						<div class="box-tools pull-right">
							{{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
										class="fa fa-minus"></i></button>
						</div>
						<!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<form action="{{ route('cuenta_show') }}" method="post">
						{{ csrf_field() }}
						<div class="box-body">
							<div class="form-group">
								<label class="control-label" for="data">DNI</label>
								<input type="number" class="form-control" name="data" id="data">
							</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i>
								Consultar
							</button>
						</div>
					</form>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
	</div>
@endsection
