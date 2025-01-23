$('#men-oper, #men-oper-upload-phone-whatsapp').addClass('active');
$("#btn-new").click(function(e) {
    clearFiles();
    $("#mdlUpload").modal("show");
});
$("#btn-search").click(function(e) {
    UploadPhoneWhatsapp.list();
});
$("#btnConvertFiles").click(function(e) {
    if ($("#uploadDate").val() == "") {
        Alert.messages.error("Debe escoger una Fecha de Carga!!!");
        return false;
    }
    if ($("#emailNotification").val() == "") {
        Alert.messages.error("Debe indicar un Email de Notificación!!!");
        return false;
    }
    if (parseInt($.customFile.elements[0].itemFileList.length) <= 0) {
        Alert.messages.error("Debe elegir por lo menos 1 Archivo a Procesar!!!");
        return false;
    }
    showLoading();
    $.customFile.ajax('#formUpload', {
        success: function(response) {
            if (parseInt(response.rst) == 1) {
                Alert.messages.success(response.msj);
                clearFiles();
                UploadPhoneWhatsapp.list();
            }
            if (parseInt(response.rst) == 2) {
                Alert.messages.error(response.msj);
            }
            removeLoading();
        },
        error: function(error) {
            switch(parseInt(error.status)) {
                case 422:
                    errorJSONTmp = error.responseJSON;
                    if (typeof errorJSONTmp.errors !== undefined) {
                        for(var i in errorJSONTmp.errors) {
                            Alert.messages.error(errorJSONTmp.errors[i]);
                            removeLoading();
                            return false;
                        }
                    }
                    break;

                default:
                    break;
            }
            removeLoading();
        }
    });
});
$(document).delegate(".btn-download-file", "click", function() {
    var pathFile = $(this).data("path");
    $.ajax({
        type : "POST",
        url  : "/operador/upload-phone-whatsapp/existFile",
        data : {pathFile : pathFile, _token : $("[name=_token]").val()},
        success  : function(obj) {
            if (obj) {
                location.href = "/operador/upload-phone-whatsapp/downloadFile/"+btoa(pathFile);
                
            } else {
                Alert.messages.error("El archivo que intenta descarga no existe o no tiene permisos para leerlo")
            }
        }
    })
});
initCustomFilesUpload = function() {
    $('#uploadFiles').customFile({
        filePicker : "<h3>Arrastra los Archivos Aquí</h3><p>o Haz clic para Seleccionarlos</p><div class='cif-icon-picker'></div>",
        maxMB : 0,
        maxFiles : 0,
        maxKBperFile : 30720,
        allowed : ["csv"],
        messages : {
            errorType : 'No puedes cargar un archivo con ese tipo de formato. Formato Válido csv',
            errorFileKB : 'El máximo tamaño de carga es de 30 MB'
        }
    });
};
clearFiles = function() {
    if (typeof $.customFile.elements[0] !== undefined) {
        while(parseInt($.customFile.elements[0].itemFileList.length) > 0) {
            $.customFile.elements[0].itemFileList[0].destroy();
        }
    }
}
$(document).ready(function (e) {
    initCustomFilesUpload();
    $('#data').keydown(function (e) {
        $('#cont-data').html($(this).val().split("\n").length)
    });
    $('#data').change(function (e) {
        $('#cont-data').html($(this).val().split("\n").length)
    });
});
$("#mdlDetail").on("show.bs.modal", function(event) {
    showLoading();
    var button = $(event.relatedTarget);
    var translateId = button.data("id");
    UploadPhoneWhatsapp.show(translateId);
});
var tDatosDetail = $("#tDatosDetail").DataTable({
    'language': {
        'url': '/Spanish.json'
    }
});
var UploadPhoneWhatsapp = {
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
            "order": [[ 1, "desc" ]],
            'ajax': {
                'url': '/operador/upload-phone-whatsapp',
                'type' : 'GET',
                'data': function ( d ) {
                    return $.extend( {}, d, {
                        "date_upload": $("#uploadDateFilter").val(),
                        "_token" : $("[name=_token]").val(),
                        "finance_entity_id" : $("#financeEntityFilter option:selected").val()
                    } );
                }
            },
            'columns': [
                { data: 'date_upload', name : 'date_upload'},
                { data: 'created_at', name : 'created_at'},
                { data: 'date_start_process', name : 'date_start_process'},
                { data: 'date_finish_process', name : 'date_finish_process'},
                { data: 'total_files', name : 'total_files'},
                { data: 'total_files_process', name : 'total_files_process'},
                { data: 'total_files_failed', name : 'total_files_failed'},
                { data: 'email_notification', name : 'email_notification'},
                { data: 'flagProcess', name : 'flagProcess'},
                { data: 'flagNotification', name : 'flagNotification'},
                { data: 'id'},
            ],
            "fnInitComplete": function() {
            },
            "drawCallback": function( settings ) {
                removeLoading();
            },
            'fnRowCallback': function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                var mdlIdTmp = "#mdlDetail";
                let btn = "";
                    /*btn+="<button class='btn btn-primary' data-target='"+mdlIdTmp+"' data-toggle='modal' ";
                        btn+=" data-id='"+aData['id']+"'>";
                        btn+="<i class='fa fa-eye'></i>";
                    btn+="</button>";*/

                    /*btn+="<button class='btn btn-danger' data-target='"+mdlIdTmp+"' ";
                        btn+=" data-id='"+aData['id']+"'>";
                        btn+="<i class='fa fa-file'></i>";
                    btn+="</button>";*/
                    $(nRow).find("td:eq(10)").html(btn);
                    removeLoading();
                }
        });
    },
    show :function(translateId) {
        $.ajax({
            url : "/operador/upload-phone-whatsapp/"+translateId+"/show",
            data : {_token : $("[name=_token]").val()},
            success: function(obj) {
                tDatosDetail.clear().draw();
                tDatosDetail.clear().draw();

                for(var j in obj.detail) {
                    let fila = [];
                    var htmlButton = "";
                    htmlButton+="<button data-path='"+obj.detail[j].file_path+"' class='btn btn-success btn-download-file'>";
                        htmlButton+="<i class='fa fa-download'></i>"
                    htmlButton+="</button>";
                    htmlButton+="<br>";
                    htmlButton+="<label>"+obj.detail[j].fileName+"</label>";
                    fila.push(htmlButton);
                    var htmlTextArea = "";
                    htmlTextArea+="<textarea rows='4' class='form-control' readonly style='width: 100% !important;'>";
                        if (obj.detail[j].translate_text!=null && obj.detail[j].translate_text!="null") {
                            htmlTextArea+=(obj.detail[j].translate_text.toUpperCase());
                        }
                    htmlTextArea+="</textarea>";
                    fila.push(htmlTextArea);
                    fila.push(obj.detail[j].process_status);
                    tDatosDetail.row.add(fila).draw();
                }
                removeLoading();
            }
        });
    }
};