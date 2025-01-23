<div id="mdlStore" class="modal fade in" id="modal-default">
	<form id="frmStore" method="post" role="form" data-toggle="validator">
		<input type="hidden" name="user_id" id="user_id">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span></button>
						<h4 class="modal-title">Usuario</h4>
					</div>
					<div class="modal-body" style="min-height: 80px">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label>Nombres y Apellidos *</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label>Rol *</label>
                                    <select class="form-control select2" id="role_id" name="role_id" required="" style="width: 100%;">
                                        <option value="" selected>Seleccione un Rol</option>
                                        @foreach($roles as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label>#Intentos Login</label>
                                    <input type="number" name="attempts_login" id="attempts_login" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
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