var ConfigUser = {
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
                'url': '/configuration/user',
                'type' : 'GET',
                'data': function ( d ) {
                    return $.extend( {}, d, {
                        "_token" : $("[name=_token]").val(),
                    } );
                }
            },
            'columns': [
                { data: 'name'},
                { data: 'key'},
                { data: 'value'},
                { data: 'created_at'},
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
                $(nRow).find('td:eq(4)').html(statusLabelOnGrid(aData["status"]))
                let btn = "";
                    btn+="<button class='btn btn-primary prepare btn-sm' data-target='#mdlStore' data-toggle='modal' ";
                        btn+=" data-id='"+aData['id']+"' style='margin-right: 5px;'>";
                        btn+="<i class='fa fa-pencil'></i>";
                    btn+="</button>";

                    $(nRow).find("td:eq(5)").html(btn);
                    removeLoading()
                switch (parseInt(aData["type"])) {
                    case 3:
                        let tmpJsonParse = parseJsonValue(aData["value"])
                        for(var i in tmpJsonParse) {
                            if (tmpJsonParse[i].selected) {
                                $(nRow).find("td:eq(2)").html(tmpJsonParse[i].name)
                            }
                        }
                        break;
                    default:
                        break; 
                }
            }
                
        });
    },
    show : function(configurationId) {
        $.get('/configuration/user/'+configurationId+'/show', function(response) {
            $("#name").val(response["name"])
            $("#key").val(response["key"])
            $("#valueInput, #valueSelect").css("display", "none")
            $("#type").val(response["type"]).trigger("change.select2")
            $("#type").prop("disabled", true)
            
            switch(parseInt(response["type"])) {
                case 1:
                    $("#valueInput").attr("type", response["type_input"])
                    $("#valueInput").val(response["value"])
                    $("#valueInput").css("display", "block")
                    break;
                case 3:
                    let tmpJson = parseJsonValue(response["value"])
                    for(var i in tmpJson) {
                        let tmpSelected = ""
                        if (tmpJson[i].selected) {
                            tmpSelected = "selected"
                        }
                        $("#valueSelect").append("<option value='"+tmpJson[i].id+"' "+tmpSelected+">"+tmpJson[i].name+"</option>")
                    }
                    $("#valueSelect").append("<input type='hidden' value='"+JSON.stringify(tmpJson)+"' name='jsonValues'/>")
                    $("#valueSelect").css("display", "block")
                    break;
                default:
                    break;
            }
            $("#status").val(response["status"]).trigger("change.select2")
            $('#configuration_id').val(response['id'])
            $('#mdlStore').modal('show')
        }, 'json');
    },
    store: function(data) {
        $.ajax({
            url: '/configuration/user/store',
            type: 'post',
            data: data + '&_token=' + $("[name=_token]").val(),
            dataType: 'json',
            beforeSend: function() {
            },
            complete: function() {

            },
            success: function(response) {
                if (parseInt(response.rst) == 1) {
                    Alert.messages.success(response.msj)
                    ConfigUser.list()
                    clearDataConfiguration()
                    removeLoading()
                    $("#mdlStore").modal("hide")
                    return
                }
                Alert.messages.error(response.msj);
                removeLoading();
            },
            error: function(response) {
                Alert.messages.error(response.responseText)
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
    clearDataConfiguration();
    
    ConfigUser.show(data["id"])
    $("html, body").animate({ scrollTop: 0 }, 600);
});
$('#frmStore').validator().on('submit', function(e) {
    if (e.isDefaultPrevented()) {
        Alert.messages.error('Debe llenar todos los campos obligatorios.');
    } else {
        e.preventDefault();
        $("#type").removeAttr("disabled")
            
        let data = $('#frmStore').serialize()
        ConfigUser.store(data)
        return false
    }
});
clearDataConfiguration = function() {
    $("#status").val(1).trigger("change.select2")
    $("#type").val(1).trigger("change.select2")
    $("#configuration_id").val("")
    $("#valueInput").val("")
    $("#valueSelect").html("")
    $('#name').val('')
    $('#key').val('')
    $('#value').val('')
};
parseJsonValue = function(valueString) {
    let tmpJson = valueString.replaceAll('&#039;', "\"")
    tmpJson = tmpJson.replaceAll('&quot;', "\"")
    let tmpJsonParse = JSON.parse(tmpJson)

    return tmpJsonParse;
};