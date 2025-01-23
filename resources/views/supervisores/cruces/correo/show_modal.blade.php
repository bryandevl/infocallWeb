<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">{{ $data->correo->documento }} {{ $data->correo->documento }} {{ $data->correo->documento }}</h4>
</div>
<div class="modal-body">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>DNI</th>
            <th>Correo</th>
<!--            <th>Periodo</th>
            <th>Condici&oacute;n</th>
            <th>Sueldo</th> -->
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $data->documento }}</td>
            <td>{{ $data->correo }}</td>
<!--            <td>{{ $data->periodo }}</td>
            <td>{{ $data->condicion }}</td>
            <td>{{ $data->sueldo }}</td> -->
        </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>