<div class="modal fade bd-example-modal-lg" id="mdlDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Transacciones de Log <span id="spanCode"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-detail" id="nav-tab-detail">Detalle</a></li>
                    <li><a data-toggle="tab" href="#tab-source" id="nav-tab-source">Fuente</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-detail" class="tab-pane fade in active">
                        @include("validata.log.partial._partial_log_detail")
                    </div>
                    <div id="tab-source" class="tab-pane fade">
                        @include("validata.log.partial._partial_log_detail_source")
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