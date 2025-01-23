<style type="text/css">
	th{font-weight: 700; text-align: center;}
	th,td,b{text-align: center;}
	th{font-weight: 700;}
</style>
<table>
	<thead>
		<tr>
            <th>DOCUMENTO</th>
            <th>PATERNO</th>
            <th>MATERNO</th>
            <th>NOMBRES</th>
            <th>NACIMIENTO</th>
            <th>DIRECCIÓN</th>
            <th>SEXO</th>
            <th>ESTADO CIVIL</th>
            <th>PADRE</th>
            <th>MADRE</th>
        </tr>
    </thead>
	<tbody>
		@foreach($infoPerson as $key => $value)
			<tr>
				<td>{{ $value["DOCUMENTO"] }}</td>
				<td>{{ $value["PATERNO"] }}</td>
				<td>{{ $value["MATERNO"] }}</td>
				<td>{{ $value["NOMBRES"] }}</td>
				<td>{{ $value["NACIMIENTO"] }}</td>
				<td>{{ $value["DIRECCIÓN"] }}</td>
				<td>{{ $value["SEXO"] }}</td>
				<td>{{ $value["ESTADO CIVIL"] }}</td>
				<td>{{ $value["PADRE"] }}</td>
				<td>{{ $value["MADRE"] }}</td>
			</tr>
		@endforeach
	</tbody>
</table>