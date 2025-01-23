var User = {
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
            "order": [[ 3, "desc" ]],
            'ajax': {
                'url': '/master/user',
                'type' : 'GET',
                'data': function ( d ) {
                    return $.extend( {}, d, {
                        "_token" : $("[name=_token]").val(),
                    } );
                }
            },
            'columns': [
                { data: 'name'},
                { data: 'email'},
                { data: 'rol', orderable: false, "searchable": false},
                { data: 'created_at'},
                { data: 'attempts_login'},
                /*{ data: 'attempts_login'},*/
                { data: 'created_at'},
                { data: 'id'},
            ],
            "fnInitComplete": function() {
                        //removeLoading();
            },
            "drawCallback": function( settings ) {
                removeLoading();
            },
            'fnRowCallback': function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                switch (parseInt(aData['status'])) {
                    case 1:
                        $(nRow).find('td:eq(5)').html('<span class="label label-success">Activo</span>');
                        break;
                    case 0:
                        $(nRow).find('td:eq(5)').html('<span class="label label-danger">Inactivo</span>');
                        break;
                }
                var mdlIdTmp = "#mdlDetail";
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
                    $(nRow).find("td:eq(6)").html(btn);
                    removeLoading();
                }
        });
    },
    show : function(userId) {
        $.get('/master/user/'+userId+'/show', function(response) {
            $("#name").val(response["name"])
            $("#email").val(response["email"])
            $("#attempts_login").val(response["attempts_login"])
            $("#role_id").val(response["role_id"]).trigger("change.select2")
            $("#status").val(response["status"]).trigger("change.select2")
            $('#user_id').val(response['id'])
            $('#mdlStore').modal('show')
        }, 'json');
    },
    destroy : function(userId) {
        $.get(
            "/master/user/"+userId+"/destroy", function(response) {
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
    store: function(data) {
        Master.userStore(data, "#mdlStore")
    }
};
$('#tDatos').on( 'click', '.prepare', function () {
    let data = tbl_data.row( $(this).parents('tr') ).data();
    if (data == undefined) {
        tbl_data = $('#tDatos').DataTable();
        data = tbl_data.row( $(this).parents('tr') ).data();
    }
    clearDataUser();
    
    User.show(data["id"])
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
                User.destroy(data["id"]);
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
    if (e.isDefaultPrevented()) {
        Alert.messages.error('Debe llenar todos los campos obligatorios.');
    } else {
        e.preventDefault();
            
        let data = $('#frmStore').serialize();
        User.store(data)
        return false
    }
});
$('#btnAdd').on('click', function() {
    clearDataUser();
    $('#mdlStore').modal('show');
});
clearDataUser = function() {
    $("#status").val(1).trigger("change.select2")
    $("#role_id").val("").trigger("change.select2")
    $("#user_id").val("")
    $('#name').val('')
    $('#email').val('')
    $('#password').val('')
    $("#attempts_login").val(0)
}