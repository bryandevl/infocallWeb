<div class="row">
    <div class="col-md-9">
        <div class="form-group">
            <label>Rango de Búsqueda</label>
            <input type="text" id="txt_fecha" class="form-control">
        </div>
    </div>
    <div class="col-md-3">
        <br>
        <button class="btn btn-success" id="btn-search">
            <i class="fa fa-search"></i>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-success box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Resultado de la Busqueda</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <div class="table-responsive-md">
                    <table class="table table-hover table-striped nowrap" id="tDatos" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 5%;">ID</th>
                                <th style="width: 5%;">Código</th>
                                <th style="width: 12%;">F.Inicio</th>
                                <th style="width: 12%;">F.Fin</th>
                                <th style="width: 8%;">#Documentos</th>
                                <th style="width: 8%;">Procesados</th>
                                <th style="width: 8%;">En Cola</th>
                                <th style="width: 8%;">Pendiente</th>
                                <th style="width: 8%;">Error</th>
                                <th style="width: 8%; white-space: break-spaces;">Duplicados en Cola</th>
                                <th style="width: 8%; white-space: break-spaces;">Duplicados en Extracción</th>
                                <th style="width: 8%;">Sin Data</th>
                                <th>[]</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div> 
            </div>
            <div class="box-footer">
                <form id="form-xls" action="/serch/xlsLog" method="POST">
                    <input type="hidden" name="flag" value="xls">
                    <input type="hidden" name="tipo" value="" id="tipoExport">
                    <input type="hidden" name="id" value="" id="idExport">
                </form>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>