<style type="text/css">
	th{font-weight: 700; text-align: center;}
	th,td,b{text-align: center;}
	th{font-weight: 700;}
</style>
<table>
	<thead>
		<tr>
            <th>DOCUMENTO</th>
            <th>CORREO</th>
        </tr>
    </thead>
	<tbody>
		@foreach($infoEmail as $key => $value)
			<tr>
				<td>{{ $value["DOCUMENTO"] }}</td>
				<td>{{ $value["CORREO"] }}</td>
			</tr>
		@endforeach
	</tbody>
</table>