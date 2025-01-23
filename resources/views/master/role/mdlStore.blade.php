<div id="mdlStore" class="modal fade in" id="modal-default">
	<form id="frmStore" method="post" role="form" data-toggle="validator">
		<input type="hidden" name="role_id" id="role_id">
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
                                    <label>Nombres *</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label>Abreviatura *</label>
                                    <input type="text" name="slug" id="slug" class="form-control" required>
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
                                            <div class="row">
                        <div class="col-xs-12">
                            <h4>Lista de Permisos</h4>
                        </div>
                        <div class="col-xs-12">
                            <div class="box-body">
                                <fieldset style="margin-bottom: 20px;">
                                    <legend>Módulos</legend>
                                    <!--<div class="col-md-9">-->
                                        <select id="listOptions" class="form-control select2" style="width: 100% !important;" multiple="multiple" name="module_id[]">
                                        @foreach($modules as $key => $value)
                                            <optgroup label="{{$value['name']}}">
                                                @foreach($value["child_modules"] as $key2 => $value2)
                                                    <option value="{{$value2['id']}}" id="listOptions_{{$value2['id']}}" data-nameparent="{{$value['name']}}" data-namechild="{{$value2['name']}}"
                                                    data-id="{{$value2['id']}}">{{$value2['name']}}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                        </select>
                                    <!--</div>-->
                                </fieldset>
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