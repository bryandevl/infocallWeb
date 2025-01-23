<div class="modal fade bd-example-modal-lg" id="mdlDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-info" id="nav-tab-info">Info</a></li>
                        {{--<li><a data-toggle="tab" href="#tab-sbs">SBS</a></li>--}}
                        <li><a data-toggle="tab" href="#tab-essalud">EsSalud</a></li>
                        <li><a data-toggle="tab" href="#tab-correo">Correo</a></li>
                        <li><a data-toggle="tab" href="#tab-familiar">Familiares</a></li>
                        <li><a data-toggle="tab" href="#tab-telefono">Teléfono</a></li>
                        <li><a data-toggle="tab" href="#tab-sbs">SBS</a></li>
                        
                    </ul>
                    <div class="tab-content">
                        <div id="tab-info" class="tab-pane fade in active">
                            @include("serch.dni.partial.tab_info")
                        </div>
                        <div id="tab-sbs" class="tab-pane fade">
                            @include("serch.dni.partial.tab_sbs")
                        </div>
                        <div id="tab-essalud" class="tab-pane fade">
                            @include("serch.dni.partial.tab_essalud")
                        </div>
                        <div id="tab-correo" class="tab-pane fade">
                            @include("serch.dni.partial.tab_correo")
                        </div>
                        <div id="tab-familiar" class="tab-pane fade">
                            @include("serch.dni.partial.tab_familiar")
                        </div>
                        <div id="tab-telefono" class="tab-pane fade">
                            @include("serch.dni.partial.tab_telefono")
                        </div>
                         </div>
                        <div id="tab-telefono" class="tab-pane fade">
                            @include("serch.dni.partial.tab_sbs")
                        </div>
                    </div>
                </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
              </div>
            </div>
        </div>
    </div>