var Master = {
    userStore : function(data, mdlStoreId) {
        $.ajax({
            url: '/master/user/store',
            type: 'post',
            data: data + '&_token=' + $("[name=_token]").val(),
            dataType: 'json',
            beforeSend: function() {
                $('#btnAdd').attr('disabled');
            },
            complete: function() {

            },
            success: function(response) {
                if (parseInt(response.rst) == 1) {
                    Alert.messages.success(response.msj)
                    if (mdlStoreId == "#mdlStore") {
                        User.list()
                        clearDataUser()
                    }
                    removeLoading()
                    $(mdlStoreId).modal("hide")
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
    },
    validateMinOldPassword : function() {
        $.get(
            '/master/user/validate-min-old-password',
            function(response) {
                if (parseInt(response.rst) == 1) {
                    let passwordUpdateNow = localStorage.getItem("pUn")
                    let tmpObject = null
                    if (passwordUpdateNow == undefined || passwordUpdateNow == "undefined") {
                        registerPUNLocalStorage()
                        tmpObject = getPUNLocalStorage()
                    } else {
                        tmpObject = getPUNLocalStorage()
                        if (afterDayTimePUNLocalStorage(tmpObject)) {
                            localStorage.removeItem("pUn")
                            registerPUNLocalStorage()
                            tmpObject = getPUNLocalStorage()
                        }
                    }
                    if (!tmpObject.close) {
                        Alert.messages.warning("Tu contraseña tiene más de "+response.minTime+" días de antiguedad. Actualicela!!!")
                        $("#mdlProfileUser").show()
                    }
                    return;
                }
                localStorage.removeItem("pUn")
            }, 'json'
        );
    }
};
registerPUNLocalStorage = function() {
    localStorage.setItem("pUn", JSON.stringify({date: Date.now(), close: false}))
};
getPUNLocalStorage = function() {
    let passwordUpdateNow = localStorage.getItem("pUn")
    let tmpObject = JSON.parse(passwordUpdateNow)
    return tmpObject;
};
afterDayTimePUNLocalStorage = function(tmpObject) {
    let dateNow = Date.now()
    let diff = dateNow - tmpObject.date
    let dayMilliSeconds = 1000 * 60 * 60 * 24
    let totalDays = Math.abs(diff / dayMilliSeconds)
    totalDays = Math.floor(totalDays); // to get complete days

    if (totalDays >=1) {
        return true;
    }
    return false;
};
$("#updateInfoProfile").on("click", function() {
    $('#frmProfileUser').submit()
});
$('#frmProfileUser').validator().on('submit', function(e) {
    if (e.isDefaultPrevented()) {
        Alert.messages.error('Debe llenar todos los campos obligatorios.');
    } else {
        e.preventDefault();
        
        let data = $('#frmProfileUser').serialize();
        Master.userStore(data, "#mdlProfileUser")
        return false
    }
});
$("#buttonMdlProfileUserClose").on("click", function() {
    let passwordUpdateNow = localStorage.getItem("pUn")
    if (passwordUpdateNow == undefined || passwordUpdateNow == "undefined") {
        let tmpObject = JSON.parse(passwordUpdateNow)
        tmpObject.close = true
        localStorage.push("pUn", JSON.stringify(tmpObject))
    }
    $("#mdlProfileUser").hide()
});
