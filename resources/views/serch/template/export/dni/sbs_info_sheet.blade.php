<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        th, td {
            font-weight: 700;
            text-align: center;
        }
        th {
            font-weight: 700;
        }
    </style>
</head>
<body>
    @if(!empty($infoSbs) && is_array($infoSbs) && count($infoSbs) > 0)
    <table>
        <thead>
            <tr>
                <th>DOCUMENTO</th>
                <th>COD_SBS</th>
                <th>FECHA REPORTE</th>
                <th>RUC</th>
                <th>CANTIDAD EMPRESAS</th>
                <th>CALIFICACION NORMAL</th>
                <th>CALIFICACION CPP</th>
                <th>CALIFICACION DEFICIENTE</th>
                <th>CALIFICACION DUDOSO</th>
                <th>CALIFICACION PERDIDA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($infoSbs as $key => $value)
            <tr>
                <td>{{ $value["DOCUMENTO"] }}</td>
                <td>{{ $value["COD_SBS"] }}</td>
                <td>{{ $value["FECHA REPORTE"] }}</td>
                <td>{{ $value["RUC"] }}</td>
                <td>{{ $value["CANTIDAD EMPRESAS"] }}</td>
                <td>{{ $value["CALIFICACION NORMAL"] }}</td>
                <td>{{ $value["CALIFICACION CPP"] }}</td>
                <td>{{ $value["CALIFICACION DEFICIENTE"] }}</td>
                <td>{{ $value["CALIFICACION DUDOSO"] }}</td>
                <td>{{ $value["CALIFICACION PERDIDA"] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No hay información de SBS disponible para mostrar.</p>
    @endif
</body>
</html>
