$("#btn-search").click(function(e) {
    Serch.list();
});
$("#btn-download").on("click", function(e) {
    if ($("#txt_dni").val() == "") {
        alert("Debe colocar por lo menos un DNI")
        return false
    }
    Serch.list(true)
    return false
});
var tableModal = $("#tDatosEssalud").DataTable({
    'language': {
        'url': '/Spanish.json'
    }
});
var tableModalCorreo = $("#tDatosCorreo").DataTable({
    'language': {
        'url': '/Spanish.json'
    }
});
var tableModalFamiliar = $("#tDatosFamiliar").DataTable({
    'language': {
        'url': '/Spanish.json'
    }
});
var tableModalTelefono = $("#tDatosTelefono").DataTable({
    'language': {
        'url': '/Spanish.json'
    }
});
$("#mdlDetail").on("show.bs.modal", function(event) {
    showLoading();
    var button = $(event.relatedTarget);
    var documento = button.data("documento");
    $.ajax({
        url : "/serch/dni/show",
        data : {_token : $("[name=_token]").val(), documento : documento},
        success: function(obj) {
            for(var i in obj) {
                let tmpId = "#"+i+"_txt";
                $(tmpId).val(obj[i]);
            }

            /*var sbs = obj.sbs;
            if (sbs!=null && sbs !="null") {
                for(var j in sbs) {
                    let tmpId = "#"+j+"_txt";
                    $(tmpId).val(sbs[j]);
                }
            }*/

            var essalud = obj.essalud;
            tableModal.clear().draw();
            for(var j in essalud) {
                let fila = [];
                fila.push(essalud[j].periodo);
                fila.push(essalud[j].ruc);
                fila.push(essalud[j].empresa);
                fila.push(essalud[j].condicion);
                fila.push(essalud[j].sueldo);
                tableModal.row.add(fila).draw();
            }

            var correos = obj.correos;
            tableModalCorreo.clear().draw();
            for(var j in correos) {
                let fila = [];
                fila.push(correos[j].correo);
                fila.push(correos[j].created_at);
                tableModalCorreo.row.add(fila).draw();
            }

            var hermanos = obj.hermanos;
            tableModalFamiliar.clear().draw();
            for(var j in hermanos) {
                let fila = [];
                fila.push(hermanos[j].documento);
                fila.push(hermanos[j].nombre);
                fila.push("HERMANO");
                tableModalFamiliar.row.add(fila).draw();
            }

            var conyuges = obj.conyuges;
            for(var j in conyuges) {
                let fila = [];
                fila.push(conyuges[j].documento);
                fila.push(conyuges[j].nombre);
                fila.push(conyuges[j].parentezco);
                tableModalFamiliar.row.add(fila).draw();
            }

            var familiares = obj.familiares;
            for(var j in familiares) {
                let fila = [];
                fila.push(familiares[j].documento);
                fila.push(familiares[j].nombre);
                fila.push(familiares[j].parentezco);
                tableModalFamiliar.row.add(fila).draw();
            }

            var telefono = obj.bitel.concat(obj.entel, obj.claro, obj.movistar, obj.movistar_fijo);
            tableModalTelefono.clear().draw();
            for(var j in telefono) {
                let fila = []
                fila.push(telefono[j].numero)
                fila.push(telefono[j].operadora)
                fila.push(telefono[j].tipoTelefono)
                fila.push(telefono[j].plan);
                fila.push(telefono[j].modelo);
                fila.push(telefono[j].fecha_activacion);
                tableModalTelefono.row.add(fila).draw();
            }
            removeLoading();
        }
    });
});
$("#mdlDetail").on("hide.bs.modal", function(event) {
    $("#nav-tab-info").tab("show");
    $("#mdlDetail input[type=text], #mdlDetail select").val("");
});
var Serch = {
    list : function(flagDownload) {
        if (flagDownload) {
            $("#formDownload").append("<input type='hidden' id='tokenFormDownload' name='_token' value='"+$('[name=_token]').val()+"' />")
            $("#formDownload").append("<input type='hidden' id='dniStringFormDownload' name='dniString' value='"+$('#txt_dni').val()+"' />")
            $("#formDownload").submit()
            $("#tokenFormDownload, #dniStringFormDownload").remove()
            return false
        }
        showLoading();
        $("#tDatos").DataTable().destroy();
        return $("#tDatos").DataTable({
            'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
            'language': {
                'url': '/Spanish.json'
            },
            'processing': true,
            'serverSide': true,
            "order": [[ 3, "desc" ]],
            'ajax': {
                'url': '/serch/listDni',
                'type' : 'POST',
                'data': function ( d ) {
                    return $.extend( {}, d, {
                        "flagTest": 1,
                        "_token" : $("[name=_token]").val(),
                        "dniString" : $("#txt_dni").val()
                    } );
                }
            },
            'columns': [
                { data: 'documento', name : 'documento' },
                { data: 'nombre' },
                { data: 'apellido_pat' },
                { data: 'apellido_mat' },
                { data: 'documento' }
            ],
            "fnInitComplete": function() {
            },
            "drawCallback": function( settings ) {
                removeLoading();
            },
            'fnRowCallback': function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                let btn = "";
                    btn+="<button class='btn btn-primary' data-target='#mdlDetail' data-toggle='modal' data-documento='"+aData['documento']+"'>";
                    btn+="<i class='fa fa-eye'></i>";
                    btn+="</button>";
                    $(nRow).find("td:eq(4)").html(btn);
                    removeLoading();
            }
        });
    }
};
$("#tDatos").DataTable({
    'language': {
        'url': '/Spanish.json'
    }
});