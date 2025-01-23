<div id="mdlProfileUser" class="modal fade in" id="modal-default">
    <form id="frmProfileUser" method="post" role="form" data-toggle="validator">
        <input type="hidden" name="user_id" id="user_id_auth" value="{{ \Auth::user()->id }}">
        <input type="hidden" name="status" id="status_auth" value="{{ \Auth::user()->id }}">
        <input type="hidden" name="role_id" id="role_id_auth" value="{{ \Auth::user()->role_id }}">
        <input type="hidden" name="fromProfileUser" value="1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#mdlProfileUser').hide();">
                        <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Usuario</h4>
                    </div>
                    <div class="modal-body" style="min-height: 80px">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label>Nombres y Apellidos *</label>
                                    <input type="text" name="name" id="name_auth" value="{{ \Auth::user()->name }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" name="email" id="email_auth" class="form-control" value="{{ \Auth::user()->email }}" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input type="password" name="password" id="password_auth" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="$('#mdlProfileUser').hide();">Cerrar</button>
                                <button type="button" id="updateInfoProfile" class="btn btn-primary">Grabar</button>
                            </div>            
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>