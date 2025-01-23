<style type="text/css">
	th{font-weight: 700; text-align: center;}
	th,td,b{text-align: center;}
</style>
<table>
	<thead>
		<tr>
			<th colspan="4">
				<b>DETALLE DE LOG</b>
			</th>
		</tr>
		<tr>
            <th><b>#</b></th>
            <th><b>DOCUMENTO</b></th>
            <th><b>ESTADO PROCESAMIENTO</b></th>
            <th><b>JOBID</b></th>
        </tr>
    </thead>
	<tbody>
		@php
			$i = 1;
		@endphp
		@foreach($detailLog as $key => $value)
			@php
				$estado = "";
				switch($value["status"]) {
                    case "PROCESS":
                        $estado = "PROCESADO";
                        break;
                    case "FAILED":
                        $estado = "FALLO PROCESO";
                        break;
                    case "ONQUEUE":
                        $estado = "EN COLA";
                        break;
                    case "REGISTER":
                        $estado = "PENDIENTE DE PROCESAR";
                        break;
                    case "REPEAT":
                        $estado = "DUPLICADO EN EL PROCESO DEL MES";
                        break;
                    case "NOTDATA":
                        $estado = "SIN DATA DE VALIDATA";
                        break;
                    default:
                        break;
                }
			@endphp
			<tr>
				<td>{{$i}}</td>
				<td>{{$value["document"]}}</td>
				<td>{{$estado}}</td>
				<td>{{$value["job_id"]}}</td>
			</tr>
			@php
				$i++;
			@endphp
		@endforeach
	</tbody>
</table>