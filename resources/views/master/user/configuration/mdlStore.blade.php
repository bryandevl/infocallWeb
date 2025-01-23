<div id="mdlStore" class="modal fade in" id="modal-default">
	<form id="frmStore" method="post" role="form" data-toggle="validator">
		<input type="hidden" name="configuration_id" id="configuration_id">
			<div class="modal-dialog modal-dialog-centered modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span></button>
						<h4 class="modal-title">Configuración de Usuario</h4>
					</div>
					<div class="modal-body" style="min-height: 80px">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label>Nombre *</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label>Key *</label>
                                    <input type="text" name="key" id="key" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label>Tipo *</label>
                                    <select class="form-control select2" id="type" name="type" required="" style="width: 100%;">
                                        <option value="1" selected>Input</option>
                                        <option value="2" disabled>Archivo</option>
                                        <option value="3">Opción Múltiple</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label>Valor</label>
                                    <input type="text" name="valueInput" id="valueInput" class="form-control">
                                    <select class="form-control" id="valueSelect" name="valueSelect" style="width: 100%;">
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label>Estado *</label>
                                    <select class="form-control select2" id="status" name="status" required="" style="width: 100%;">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
						
                    </div>
					<div class="modal-footer">
        				<div class="col-xs-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Grabar</button>               
                            </div>            
                        </div>
					</div>
				</div>
			</div>
		</form>
	</div>