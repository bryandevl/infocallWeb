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
            <th>NOMBRE</th>
            <th>DOCUMENTO FAM.</th>
            <th>NOMBRES FAM.</th>
            <th>TIPO FAM.</th>
        </tr>
    </thead>
	<tbody>
		@foreach($infoParents as $key => $value)
			<tr>
				<td>{{ $value["DOCUMENTO"] }}</td>
				<td>{{ $value["PATERNO"] }}</td>
				<td>{{ $value["MATERNO"] }}</td>
				<td>{{ $value["NOMBRE"] }}</td>
				<td>{{ $value["DOCUMENTO FAM."] }}</td>
				<td>{{ $value["NOMBRES FAM."] }}</td>
				<td>{{ $value["TIPO FAM."] }}</td>
			</tr>
		@endforeach
	</tbody>
</table>