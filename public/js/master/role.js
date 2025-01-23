var Role = {
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
                'url': '/master/roles',
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
                { data: 'name'},
                { data: 'slug'},
                { data: 'created_at'},
                { data: 'created_at'},
                { data: 'id'},
            ],
            "fnInitComplete": function() {
                removeLoading();
            },
            "drawCallback": function( settings ) {
                removeLoading();
            },
            'fnRowCallback': function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                switch (parseInt(aData['status'])) {
                    case 1:
                        $(nRow).find('td:eq(3)').html('<span class="label label-success">Activo</span>');
                        break;
                    case 0:
                        $(nRow).find('td:eq(3)').html('<span class="label label-danger">Inactivo</span>');
                        break;
                }
                let btn = "";
                    btn+="<button class='btn btn-primary prepare btn-sm' data-target='#mdlStore' data-toggle='modal' ";
                        btn+=" data-id='"+aData['id']+"' style='margin-right: 5px;'>";
                        btn+="<i class='fa fa-pencil'></i>";
                    btn+="</button>";
                    btn += '<button class="btn btn-danger btn-sm destroy">';
                        btn += '<i class="fa fa-trash"></i>'
                    btn += '</button>';

                    /*btn+="<button class='btn btn-danger' data-target='"+mdlIdTmp+"' ";
                        btn+=" data-id='"+aData['id']+"'>";
                        btn+="<i class='fa fa-file'></i>";
                    btn+="</button>";*/
                    $(nRow).find("td:eq(4)").html(btn);
                    removeLoading();
                }
        });
    },
    show : function(roleId) {
        $.get('/master/roles/'+roleId+'/show', function(response) {
            $("#name").val(response["name"])
            $("#slug").val(response["slug"])
            $("#status").val(response["status"]).trigger("change.select2")
            $('#role_id').val(response['id'])

            var array = [];
            for(var i in response["modules"]) {
                let moduleTmp = response["modules"][i].module_id;
                array.push(moduleTmp);
            }
            $("#listOptions").val(array).trigger("change");

            $('#mdlStore').modal('show')
        }, 'json');
    },
    destroy : function(roleId) {
        $.get(
            "/master/roles/"+roleId+"/destroy", function(response) {
            $("#tbl_data").DataTable().ajax.reload();
            if (parseInt(response.rst) == 1) {
                Alert.messages.success(response.msj)
                $("#tDatos").DataTable().ajax.reload()
                clearDataRole()
                removeLoading()
                return
            }
            Alert.messages.error(response.msj)
            removeLoading()
         }, 'json');
    },
    store : function(data) {
        $.ajax({
            url: '/master/roles/store',
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
                    Role.list()
                    clearDataRole()
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
$('#tDatos').on( 'click', '.prepare', function () {
    let data = tbl_data.row( $(this).parents('tr') ).data();
    if (data == undefined) {
        tbl_data = $('#tDatos').DataTable();
        data = tbl_data.row( $(this).parents('tr') ).data();
    }
    clearDataRole();
    
    Role.show(data["id"])
    $("html, body").animate({ scrollTop: 0 }, 600);
});
$('#tDatos').on( 'click', '.destroy', function () {
    showLoading();
    let data = tbl_data.row( $(this).parents('tr') ).data();
    if(data == undefined) {
        tbl_data = $('#tDatos').DataTable();
        data = tbl_data.row( $(this).parents('tr') ).data();
    }

    $.confirm({
        icon: 'fa fa-question',
        theme: 'modern',
        animation: 'scale',
        title: '¿Está seguro de eliminar este registro?',
        content: '',
        buttons: {
            Confirmar: function () {
                Role.destroy(data["id"]);
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
        Role.store(data);
    }
});
$('#btnAdd').on('click', function() {
    clearDataRole();
    $('#mdlStore').modal('show');
});
clearDataRole = function() {
    $('#name').val('')
    $('#slug').val('')
    $("#status").val("1").trigger("change.select2")
    $("#listOptions").val([]).trigger("change")
};