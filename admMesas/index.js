// JavaScript Document

function fn_cerrar(){
	$.unblockUI({ 
		onUnblock: function(){
			$("#div_oculto").html("");
		}
	}); 
};

function fn_mostrar_frm_agregar(){
	$("#div_oculto").load("ajax_form_agregar.php", function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '20%'
			}
		}); 
	});
};

function fn_mostrar_frm_modificar(ide_ped){
	$("#div_oculto").load("ajax_form_modificar.php", {ide_ped: ide_ped}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '20%'
			}
		}); 
	});
};

function fn_buscar(ide_ped){
//	var str = $("#frm_buscar").serialize();
	$.ajax({
		url: 'ajax_listar.php',
		type: 'post',
		data: 'ide_ped=' + ide_ped,
		success: function(data){
			$("#div_listar").html(data);
                        startTimer();
		}
	});
}

function fn_guardar(ide_ped){
	$.ajax({
		url: 'ajax_guardar.php',
		type: 'post',
		data: 'ide_ped=' + ide_ped,
		success: function(data){
			$("#div_listar").html(data);
		}
	});
}