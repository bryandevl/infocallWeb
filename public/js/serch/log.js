$("#txt_fecha").daterangepicker({
    singleDatePicker: false,
    maxViewMode: 2,
    showDropdowns: true,
    minDate: moment().subtract(365, 'days'),
    maxDate:  moment(),
    startDate: moment().subtract(31, 'days'),
    endDate: moment(),
    locale: {format: 'YYYY-MM-DD'}
});
var Log = {
	list : function() {
        showLoading();
        $("#tDatos").DataTable().destroy();
        return $("#tDatos").DataTable({
            'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
            'language': {
                'url': '/Spanish.json'
            },
            'processing': true,
            'serverSide': true,
            "order": [[ 0, "desc" ]],
            'ajax': {
                'url': '/serch/log',
                'type' : 'GET',
                'data': function ( d ) {
                    return $.extend( {}, d, {
                        "flagTest": 1,
                        "_token" : $("[name=_token]").val(),
                            "fecha" : $("#txt_fecha").val()
                    } );
                }
            },
            'columns': [
                { data: 'id', name : 'id'},
                { data: 'code', name : 'code'},
                /*{ data: 'created_at', name : 'created_at'},*/
                { data: 'time_start'},
                { data: 'time_end'},
                { data: 'total', orderable: false},
                { data: 'total_process', orderable: false},
                { data: 'total_onqueue', orderable: false},
                { data: 'total_pending', orderable: false},
                { data: 'total_failed', orderable: false},
                { data: 'total_repeat', orderable: false},
                { data: 'duplicate_total_on_period', orderable: false},
                { data: 'total_notdata', orderable: false},
                { data: 'id', orderable: false},
            ],
            "fnInitComplete": function() {
                        //removeLoading();
            },
            "drawCallback": function( settings ) {
                removeLoading();
            },
            'fnRowCallback': function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                var mdlIdTmp = "";
                let btn = "";
                    btn+="<button class='btn btn-primary' data-target='#mdlDetail' data-toggle='modal' ";
                    btn+=" data-id='"+aData['id']+"' >";
                    btn+="<i class='fa fa-eye'></i>";
                    btn+="</button>";

                    btn+="<button class='btn btn-danger btn-xls' data-id='"+aData['id']+"' style='margin-left:5px;'>";
                    btn+="<i class='fa fa-download'></i>";
                    btn+="</button>";
                    $(nRow).find("td:eq(12)").html(btn);
                    removeLoading();
                }
        });
    },
    show :function(logId) {
        $.ajax({
            url : "/serch/log/show",
            data : {_token : $("[name=_token]").val(), id : logId},
            success: function(obj) {
                $("#spanCode").empty();
                $("#spanCode").html(obj.code);
                tDatosDetail.clear().draw();
                tDatosDetail.clear().draw();

                tDatosDetailSource.clear().draw();
                tDatosDetailSource.clear().draw();

                var detail = obj.detail;
                var source = [];
                var k = 1;
                for(var j in detail) {
                    let fila = [];
                    var estado = "";
                    switch(detail[j].status) {
                        case "PROCESS":
                            estado = "PROCESADO";
                            break;
                        case "FAILED":
                            estado = "FALLO PROCESO";
                            break;
                        case "ONQUEUE":
                            estado = "EN COLA";
                            break;
                        case "REGISTER":
                            estado = "PENDIENTE DE PROCESAR";
                            break;
                        case "REPEAT":
                            estado = "DUPLICADO EN EL PROCESO DEL MES";
                            break;
                        case "NOTDATA":
                            estado = "SIN DATA";
                            break;
                        default:
                            break;
                    }
                    fila.push(k);
                    fila.push(detail[j].document);
                    fila.push(estado);
                    fila.push(detail[j].job_id);
                    tDatosDetail.row.add(fila).draw();
                    k++;

                    var sourceTmp = detail[j].source_trace;
                    for(var m in sourceTmp) {
                        source.push(sourceTmp[m]);
                    }
                }

                var k = 1;
                for(var j in source) {
                    let fila = [];
                    var accion = "";
                    var dataTmp = {};
                    fila.push(k);
                    fila.push(source[j].document);
                    switch(source[j].action_type) {
                        case "CREATE":
                            accion = "REGISTRO NUEVO";
                            dataTmp = JSON.parse(source[j].value_create);
                            break;
                        case "UPDATE":
                            accion = "REGISTRO ACTUALIZADO";
                            dataTmp = JSON.parse(source[j].value_update);
                            break;
                        case "DELETE":
                            accion = "REGISTRO ELIMINADO";
                            break;
                        default:
                            break;
                    }
                    fila.push(accion);
                    fila.push(source[j].process_source);
                    var dataTmpHtml = "";
                        dataTmpHtml+="<table class='table nowrap'>";
                        dataTmpHtml+="<tbody>";
                    for(var n in dataTmp) {
                        dataTmpHtml+="<tr>";
                        dataTmpHtml+="<td style='width: 100px; text-align: left;'><b>"+n+":</b></td>";
                        dataTmpHtml+="<td style='text-align: left;'>"+dataTmp[n]+"</td>";
                        dataTmpHtml+="</tr>";
                    }
                    dataTmpHtml+="</tbody>";
                    dataTmpHtml+="</table>";
                    fila.push(dataTmpHtml);
                    tDatosDetailSource.row.add(fila).draw();
                    k++;
                    console.log(JSON.parse(source[j].value_create));
                    console.log(JSON.parse(source[j].value_update));
                }
                removeLoading();
            }
        });
    },
    showChart : function() {
        var cPeriodo = $("#slct_cPERIODO option:selected").val();
        var campaignId = $("#slct_campaign_id option:selected").val();
        if (cPeriodo == "") {
            Alert.messages.error("Debe elegir un Período!!!");
            return false;
        }
        $("#contentChartTotales").empty();
        $("#contentChartCampaigns").empty();

        showLoading();
        $.ajax({
            url  : "/serch/log/show-chart",
            data : {_token : $("[name=_token]").val(), cPERIODO : cPeriodo, campaign_id : campaignId},
            success: function(obj) {
                
                $("#contentChartTotales").html(obj.chartTotales);
                //$("#contentChartCampaigns").html(obj.chartTotales);
                $("#contentChartCampaigns").html(obj.chartCampaigns);
                removeLoading();
            },
            error: function(error) {
                removeLoading();
            }
        });
    }
};
$("#btn-search").click(function(){
    Log.list();
});
$("#btn-resumen").click(function(){
    Log.showChart();
});
var tDatosDetail = $("#tDetail").DataTable({
    'language': {
        'url': '/Spanish.json'
    },
    "ordering": true
});
var tDatosDetailSource = $("#tDetailSource").DataTable({
    'language': {
        'url': '/Spanish.json'
    },
    "ordering": true
});
$(document).delegate(".btn-xls", "click", function(e){
    var logId = $(this).data("id");
    $("#idExport").val(logId);
    var tokenTmp = $("[name=_token]").val();
    $("#form-xls").append("<input type='hidden' name='_token' value='"+tokenTmp+"' id='tokenTmp'/>");
    $("#form-xls").submit();
    $("#idExport").val("");
    $("#tokenTmp").remove();
});
$("#mdlDetail").on("show.bs.modal", function(event) {
    showLoading();
    var button = $(event.relatedTarget);
    var logId = button.data("id");
    Log.show(logId);
});
$("ul.nav-tabs li a").click(function(event) {
    var hrefTab = event.target.getAttribute("href");
    switch(hrefTab) {
        case "#tab-resumen":
            break;
        case "#tab-search":
            Log.list();
            break;
        default:
            break;
    }
});
Log.showChart();