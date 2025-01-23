<style type="text/css">
	th{font-weight: 700; text-align: center;}
	th,td,b{text-align: center;}
</style>
<table>
	<thead>
		<tr>
			<th colspan="5">
				<b>DETALLE DE LOG SOURCE</b>
			</th>
		</tr>
		<thead>
            <tr>
                <th>#</th>
                <th>DOCUMENTO</th>
                <th>ACCION</th>
                <th>FUENTE</th>
                <th>DATA</th>
            </tr>
        </thead>
    </thead>
	<tbody>
		@php
			$i = 1;
		@endphp
		@foreach($sourceLog as $key => $value)
			@php
				$accion = "";
				$rowspan = 1;
				$dataTmp = [];
				switch($value["action_type"]) {
					case "CREATE":
						$accion = "REGISTRO NUEVO";
						$dataTmp = json_decode($value["value_create"], true);
						break;
					case "UPDATE":
						$accion = "REGISTRO ACTUALIZADO";
						$dataTmp = json_decode($value["value_update"], true);
						break;
					case "DELETE":
						$accion = "REGISTRO ELIMINADO";
						break;
					default:
						break;
				}
				if (count($dataTmp) > 0) {
					$rowspan = count($dataTmp);
				}
				$j = 0;
			@endphp
			<tr>
				<td rowspan="{{$rowspan}}">{{$i}}</td>
				<td rowspan="{{$rowspan}}">{{$value["document"]}}</td>
				
				<td rowspan="{{$rowspan}}">{{$accion}}</td>
				<td rowspan="{{$rowspan}}">{{$value["process_source"]}}</td>
				@if($rowspan > 1)
					@php
						$firstRow = "";
						foreach ($dataTmp as $key2 => $value2) {
							if ($j == 0) {
								$firstRow = $key2.": ".$value2;
							}
							$j++;
						}
					@endphp
					<td rowspan="1">{{$firstRow}}</td>
				@else
					<td rowspan="1"></td>
				@endif
			</tr>
			@if($rowspan > 1)
				@php
					$k = 0;
				@endphp
				
					@foreach($dataTmp as $key3 => $value3)
						@if($k > 0)
						<tr>
							<td>{{$key3}}: {{$value3}}</td>
						</tr>
						@endif
						@php
							$k++;
						@endphp
					@endforeach
				
			@endif
			@php
				$i++;
			@endphp
		@endforeach
	</tbody>
</table>