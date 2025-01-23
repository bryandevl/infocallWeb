<div id="mdlStore" class="modal fade in" id="modal-default">
	<form id="frmStore" method="post" role="form" data-toggle="validator">
		<input type="hidden" name="module_id" id="module_id">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span></button>
						<h4 class="modal-title">Módulo</h4>
					</div>
					<div class="modal-body" style="min-height: 80px">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label>Nombres *</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6" id="content-class-icon">
                                <div class="form-group">
                                    <label>Icono</label>
                                    <input type="text" name="class_icon" id="class_icon" class="form-control">
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label>Visible *</label>
                                    <select class="form-control select2" id="visible" name="visible" required="" style="width: 100%;">
                                        <option value="" selected>Elige</option>
                                        <option value="1" selected>SI</option>
                                        <option value="0">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label>Orden</label>
                                    <input type="number" name="order" id="order" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label>Ruta en el Sistema</label>
                                    <input type="text" name="url" id="url" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6" id="content-module-parent">
                                <div class="form-group">
                                    <label>Módulo Padre</label>
                                    <select class="form-control select2" id="module_parent_id" name="module_parent_id" style="width: 100%;">
                                        <option value="" selected>Elige un Módulo Padre</option>
                                        @foreach($modulesParent as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label>Estado *</label>
                                    <select class="form-control select2" id="status" name="status" required="" style="width: 100%;">
                                        <option value="" selected>Elige un Estado</option>
                                        <option value="1" selected>Activo</option>
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