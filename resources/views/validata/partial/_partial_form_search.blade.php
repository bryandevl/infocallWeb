<form id="formSearch" method="POST">
	<div class="row">
		<div class="col-md-12">
            <div class="form-group">
                <label>Ingresa DNI</label>
                <input type="number" id="txt_document" class="form-control" placeholder="Ingrese el DNI" name="document">
            </div>
            <div class="form-group">
                <label>Nombres</label>
                <input type="text" id="txt_names" class="form-control blocked-diferent-document" placeholder="Ingrese tu Nombres" name="names">
            </div>
            <div class="form-group">
                <label>Apellido Paterno</label>
                <input type="text" id="txt_last_name" class="form-control blocked-diferent-document" placeholder="Ingrese el Apellido Paterno" name="last_name">
            </div>
            <div class="form-group">
                <label>Apellido Materno</label>
                <input type="text" id="txt_surname" class="form-control blocked-diferent-document" placeholder="Ingrese el Apellido Materno" name="surname">
            </div>
            <div class="form-group">
                <label>Teléfono</label>
                <input type="number" id="txt_phone" class="form-control blocked-diferent-document" placeholder="Ingrese el Teléfono" name="phone">
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-sm-6">
                    <button class="btn btn-success form-control">
                        <i class="fa fa-search"></i><span style="margin-left: 5px;">BUSCAR</span>
                    </button>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-warning form-control">
                        <i class="fa fa-trash"></i><span style="margin-left: 5px;">LIMPIAR</span>
                    </a>
                </div>
            </div>                                
        </div>
    </div>
</form>