@extends("notifications.default")
@section("content")
<style type="text/css">
	p {padding: 5px 10px;}
	th{font-weight: 700;}
	.derecha{text-align: right;}
</style>
<p><b>Hola,</b></p>
<p>Se ha procesado la Carga de Correos #{{str_pad($upload['id'], 8, "0", STR_PAD_LEFT)}}</p>
<div style="width: 100%">
	<table style="border-bottom: solid 1px; width: 90%; margin: 5px auto;">
		<thead>
			<th>DETALLE DE LA CARGA</th>
		</thead>
	</table>
	<table style="width: 90%; margin: 5px auto;">
		<tbody>
			<tr>
				<td><b>FECHA DE CARGA : </b></td>
				<td class="derecha">{{$upload['date_upload']}}</td>
			</tr>
			<tr>
				<td><b>TOTAL CORREOS : </b></td>
				<td class="derecha">{{$upload['total_files']}}</td>
			</tr>
			<tr>
				<td><b>CORREOS ACTUALIZADOS : </b></td>
				<td class="derecha">{{$upload['total_files_process']}}</td>
			</tr>
			<tr>
				<td><b>CORREOS NO ACTUALIZADOS : </b></td>
				<td class="derecha">{{$upload['total_files_failed']}}</td>
			</tr>
		</tbody>
	</table>
	<table style="border-bottom: solid 1px; width: 90%; margin: 5px auto;">
		<thead>
			<th>ARCHIVOS DE LA CARGA</th>
		</thead>
	</table>
	<table style="width: 90%; margin: 5px auto;">
		<tbody>
			@foreach($detail as $key => $value)
			<tr>
				<td><b>{{$value['fileName']}}</b></td>
				@php
					$pathEncode = base64_encode($value['file_path']);
					$urlDownload = route("supervisores.upload_correo.download_file", ["path" => $pathEncode]);
				@endphp
				<td class="derecha"><a href="{{$urlDownload}}">Descargar Archivo</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection