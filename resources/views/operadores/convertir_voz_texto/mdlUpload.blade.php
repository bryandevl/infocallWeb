<div class="modal fade bd-example-modal-lg" id="mdlUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlUploadTitle">Nueva Carga de Archivos de Voz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="mdlUploadButton">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-info" id="nav-tab-info">Carga</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-info" class="tab-pane fade in active">
                        <form 
                            id="formUpload"
                            action="{{route('operador.convertir_voz_texto.store')}}"
                            method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Entidad Financiera</label>
                                        <select class="form-control selectpicker" data-live-search="true" data-size="10" name="finance_entity_id" id="financeEntityId">
                                            <option value="">Selecciona una Entidad</option>
                                            @foreach($financeEntities as $key => $value)
                                            <optgroup label="{{$key}}">
                                                @foreach($value as $key2 => $value2)
                                                <option value="{{$value2['id']}}">{{$value2['description']}}</option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Fecha Carga</label>
                                        <input type="date" class="form-control" value="{{date('Y-m-d')}}" placeholder="yyyy-mm-dd" name="upload_date" id="uploadDate"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Email de Notificación</label>
                                        <input type="email" name="email" class="form-control" placeholder="Colocar un Email para Notificar el Término de Proceso" id="emailNotification" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input name="uploadFiles" id="uploadFiles" class="form-control uploadFiles"> 
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnConvertFiles">Traducir Archivos</button>
              </div>
        </div>
    </div>
</div>