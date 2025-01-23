<style type="text/css">
	th{font-weight: 700; text-align: center;}
	th,td,b{text-align: center;}
	th{font-weight: 700;}
</style>
<table>
	<thead>
		<tr>
            <th>DOCUMENTO</th>
            <th>FECHA</th>
            <th>RUC</th>
            <th>NOMBRE EMPRESA</th>
            <th>SUELDO</th>
            <th>SITUACIÓN</th>
        </tr>
    </thead>
	<tbody>
		@foreach($infoEssalud as $key => $value)
			<tr>
				<td>{{ $value["DOCUMENTO"] }}</td>
				<td>{{ $value["FECHA"] }}</td>
				<td>{{ $value["RUC"] }}</td>
				<td>{{ $value["NOMBRE EMPRESA"] }}</td>
				<td>{{ $value["SUELDO"] }}</td>
				<td>{{ $value["SITUACIÓN"] }}</td>
			</tr>
		@endforeach
	</tbody>
</table>