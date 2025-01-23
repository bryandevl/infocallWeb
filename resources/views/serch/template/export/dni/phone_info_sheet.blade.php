<style type="text/css">
	th{font-weight: 700; text-align: center;}
	th,td,b{text-align: center;}
	th{font-weight: 700;}
</style>
<table>
	<thead>
		<tr>
            <th>DOCUMENTO</th>
            <th>TELÉFONO</th>
            <th>TIPO TELÉFONO</th>
            <th>OPERADOR</th>
            <th>ORIGEN DATA</th>
            <th>FECHA DATA</th>
            <th>PLAN</th>
            <th>FECHA ACTIVACIÓN</th>
            <th>MODELO</th>
        </tr>
    </thead>
	<tbody>
		@foreach($infoPhones as $key => $value)
			<tr>
				<td>{{ $value["DOCUMENTO"] }}</td>
				<td>{{ $value["TELÉFONO"] }}</td>
				<td>{{ $value["TIPO TELÉFONO"] }}</td>
				<td>{{ $value["OPERADOR"] }}</td>
				<td>{{ $value["ORIGEN DATA"] }}</td>
				<td>{{ $value["FECHA DATA"] }}</td>
				<td>{{ $value["PLAN"] }}</td>
				<td>{{ $value["FECHA ACTIVACION"] }}</td>
				<td>{{ $value["MODELO"] }}</td>
			</tr>
		@endforeach
	</tbody>
</table>