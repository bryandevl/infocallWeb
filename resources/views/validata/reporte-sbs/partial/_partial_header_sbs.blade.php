<div class="col-sm-3">
    <h5>
        <b>{{$people['last_name']}} {{$people['surname']}}, {{$people['names']}}</b>
    </h5>
    <p>Fecha de Nacimiento: {{$people['birth']}}</p>
</div>
<div class="col-sm-1">
    <p style="text-align: center;">Semáforo Actual</p>
    <div class="circle-semaforo-externo btn">
        <div class="circle-semaforo-interno btn {{$classBtnLatest}}"></div>
    </div>
</div>
<div class="col-sm-5">
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <th>Documento</th>
            <th>Última Actualización</th>
            <th>Monto Total (S/.)</th>
        </thead>
        <tbody>
            <tr>
                <td>{{$document}}</td>
                <td>{{$latest}}</td>
                <td>{{$latestAmount}}</td>
            </tr>
        </tbody>
    </table>
</div>