$("#txt_document").keyup(function() {
	$(".blocked-diferent-document").val("");
	$(".blocked-diferent-document").removeAttr("disabled");
	if ($("#txt_document").val() != "") {
		$(".blocked-diferent-document").prop("disabled", true);
	}
});
$(".blocked-diferent-document").keyup(function() {

});
$("#formSearch").submit(function(e) {
	var txtDocument = $("#txt_document").val();
	var txtPhone = $("#txt_phone").val();
	var txtNames = $("#txt_names").val();
	var txtLastName = $("#txt_last_name").val();
	var txtSurName = $("#txt_surname").val();

	if (txtDocument != "") {
		if (isNaN(txtDocument)) {
			Alert.messages.error("Debe colocar un Número de Documento Válido");
        		return false;
		}
	} else {
		if (txtPhone != "") {

		} else {
			if (parseInt(txtNames.length) < 3) {
				Alert.messages.error("Debe colocar un Nombre de por lo menos 3 letras");
        		return false;
			}
			if (parseInt(txtLastName.length) < 3) {
				Alert.messages.error("Debe colocar un Apellido Paterno de por lo menos 3 letras");
        		return false;
			}
			if (parseInt(txtSurName.length) < 3) {
				Alert.messages.error("Debe colocar un Apellido Materno de por lo menos 3 letras");
        		return false;
			}
		}
	}
	var url = $("[name=actionFormSearch]").val();
	var form = $("#formSearch").serialize();
	form+="&_token="+$("[name=_token]").val();
	showLoading();
	$.ajax({
		type	: 	"POST",
		url		: 	url,
		data	: 	form,
		success	: 	function(obj) {
			tableSearch.clear().draw();
			tableSearch.clear().draw();
			if (obj.length > 0) {
				for(var i in obj) {
					let fila = [];
					fila.push(obj[i].document);
					fila.push(obj[i].names);
					fila.push(obj[i].last_name);
					fila.push(obj[i].surname);
					var btn = "<button class='btn btn-primary btn-reporte-sbs' ";
						btn+=" data-document='"+obj[i].document+"' >";
						btn+=" <i class='fa fa-child' aria-hidden='true'></i>";
						btn+="</button>";
					fila.push(btn);
					tableSearch.row.add(fila).draw();
				}
			} else {
				Alert.messages.error("No existe coincidencia en la búsqueda");
			}
			removeLoading();
		},
		error	: 	function(error) {

		}
	})
	return false;
});
$(document).delegate(".btn-reporte-sbs", "click", function(event) {
	showLoading();
	var button = $(event.currentTarget);
	var documentTmp = button.data("document");
	var urlForm = $("#urlReporteSbsResult").val();
	console.log(urlForm);
	location.href = urlForm+btoa(documentTmp);
});