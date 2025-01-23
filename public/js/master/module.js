var Module = {
	list : function(columns, fnDrawCallback, withChilds, tableId) {
        showLoading();
        $(tableId).DataTable().destroy();
        return $(tableId).DataTable({
            'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
            'language': {
                'url': '/Spanish.json'
            },
            'processing': true,
            'serverSide': true,
            "order": [[ 0, "desc" ]],
            'ajax': {
                'url': '/master/module',
                'type' : 'GET',
                'data': function ( d ) {
                    return $.extend( {}, d, {
                        "_token" : $("[name=_token]").val(),
                        "withChilds" : withChilds
                    } );
                }
            },
            'columns': columns,
            "fnInitComplete": function() {
                removeLoading();
            },
            "drawCallback": function( settings ) {
                removeLoading();
            },
            'fnRowCallback': function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                fnDrawCallback(nRow, aData, iDisplayIndex, iDisplayIndexFull)
                removeLoading();
            }
        });
    },
    show : function(moduleId) {
        $.get('/master/module/'+moduleId+'/show', function(response) {
            $("#name").val(response["name"])
            $("#class_icon").val(response["class_icon"])
            $("#order").val(response["order"])
            $("#url").val(response["url"])
            $("#status").val(response["status"]).trigger("change.select2")
            $("#visible").val(response["visible"]).trigger("change.select2")
            $("#module_parent_id").val(response["module_parent_id"]).trigger("change.select2")
            $('#module_id').val(response['id'])
            $('#mdlStore').modal('show')
        }, 'json');
    },
    destroy : function(roleId) {
        $.get(
            "/master/module/"+roleId+"/destroy", function(response) {
            if (parseInt(response.rst) == 1) {
                Alert.messages.success(response.msj)
                if (viewTabModule) {
                    Module.list(tbModulesColumns, fnRowCallbackTbModules, false, "#tbModules")
                } else {
                    Module.list(tbModulesChildsColumns, fnRowCallbackTbModulesChilds, true, "#tbModulesChilds")
                }
                clearDataModule()
                removeLoading()
                return
            }
            Alert.messages.error(response.msj)
            removeLoading()
         }, 'json');
    },
    store : function(data) {
        $.ajax({
            url: '/master/module/store',
            type: 'post',
            data: data,
            dataType: 'json',
            beforeSend: function() {
                $('#btnAdd').attr('disabled');
            },
            complete: function() {

            },
            success: function(response) {
                if (parseInt(response.rst) == 1) {
                    Alert.messages.success(response.msj)
                    if (viewTabModule) {
                        Module.list(tbModulesColumns, fnRowCallbackTbModules, false, "#tbModules")
                    } else {
                        Module.list(tbModulesChildsColumns, fnRowCallbackTbModulesChilds, true, "#tbModulesChilds")
                    }
                    clearDataModule()
                    removeLoading()
                    $("#mdlStore").modal("hide")
                    return
                }
                Alert.messages.error(response.msj);
                removeLoading();
            },
            error: function(response) {
                Alert.messages.error(response.responseText);
                $('#btnAdd').removeAttr('disabled');
                removeLoading()
            }
        });
    }
};
$('#tbModules').on( 'click', '.prepare', function () {
    let data = tbModules.row( $(this).parents('tr') ).data();
    if (data == undefined) {
        tbModules = $('#tbModules').DataTable();
        data = tbModules.row( $(this).parents('tr') ).data();
    }
    clearDataModule();
    
    Module.show(data["id"])
    $("html, body").animate({ scrollTop: 0 }, 600);
});
$('#tbModulesChilds').on( 'click', '.prepare', function () {
    let data = tbModulesChilds.row( $(this).parents('tr') ).data();
    if (data == undefined) {
        tbModulesChilds = $('#tbModulesChilds').DataTable();
        data = tbModulesChilds.row( $(this).parents('tr') ).data();
    }
    clearDataModule();
    
    Module.show(data["id"])
    $("html, body").animate({ scrollTop: 0 }, 600);
});
$('#tbModules').on( 'click', '.destroy', function () {
    showLoading();
    let data = tbModules.row( $(this).parents('tr') ).data();
    if(data == undefined) {
        tbModules = $('#tbModules').DataTable();
        data = tbModules.row( $(this).parents('tr') ).data();
    }

    $.confirm({
        icon: 'fa fa-question',
        theme: 'modern',
        animation: 'scale',
        title: '¿Está seguro de eliminar este módulo?',
        content: '',
        buttons: {
            Confirmar: function () {
                Module.destroy(data["id"]);
                $("html, body").animate({ scrollTop: 0 }, 600);
            },
            Cancelar: function () {
                removeLoading();
            }
        }
    });
    $("html, body").animate({ scrollTop: 0 }, 600);
});
$('#tbModulesChilds').on( 'click', '.destroy', function () {
    showLoading();
    let data = tbModules.row( $(this).parents('tr') ).data();
    if(data == undefined) {
        tbModulesChilds = $('#tbModulesChilds').DataTable();
        data = tbModulesChilds.row( $(this).parents('tr') ).data();
    }

    $.confirm({
        icon: 'fa fa-question',
        theme: 'modern',
        animation: 'scale',
        title: '¿Está seguro de eliminar este submódulo?',
        content: '',
        buttons: {
            Confirmar: function () {
                Module.destroy(data["id"]);
                $("html, body").animate({ scrollTop: 0 }, 600);
            },
            Cancelar: function () {
                removeLoading();
            }
        }
    });
    $("html, body").animate({ scrollTop: 0 }, 600);
});
$('#frmStore').validator().on('submit', function(e) {
    if(e.isDefaultPrevented()) {
        Alert.messages.error('Debe llenar todos los campos obligatorios.');
    } else {
        e.preventDefault();
        let data = $('#frmStore').serialize();
        data+="&_token="+$("[name=_token]").val();
        showLoading();
        Module.store(data);
    }
});
$('#btnAdd').on('click', function() {
    clearDataModule();
    $('#mdlStore').modal('show');
});
clearDataModule = function() {
    if (viewTabModule) {
        $("#content-module-parent").addClass("divHidden")
        $("#content-class-icon").removeClass("divHidden")
    } else {
        $("#content-module-parent").removeClass("divHidden")
        $("#content-class-icon").addClass("divHidden")
    }
    $('#name, #class_icon, #url, #module_id').val('')
    $("#order").val(0)
    $("#module_parent_id, #visible").val("").trigger("change.select2")
    $("#status").val("1").trigger("change.select2")
};