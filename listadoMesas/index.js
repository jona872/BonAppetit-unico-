// JavaScript Document
$(document).ready(function(){
       fn_buscar();
       $("#grilla tbody tr").mouseover(function(){
               $(this).addClass("over");
       }).mouseout(function(){
               $(this).removeClass("over");
       });
   });   
    
function fn_cerrar(){
	$.unblockUI({ 
		onUnblock: function(){
			$("#div_oculto").html("");
		}
	}); 
};

function fn_buscar(){
	var str = $("#frm_buscar").serialize();
	$.ajax({
		url: 'ajax_listar.php',
		type: 'get',
		data: str,
		success: function(data){
			$("#div_listar").html(data);
		}
	});
}


function fn_eliminar(ide_ped){
            var respuesta = confirm("Desea cancelar la mesa?");
            if (respuesta){
                    $.ajax({
                            url: 'ajax_eliminar.php',
                            data: 'ide_ped=' + ide_ped,
                            type: 'post',
                            success: function(data){
                                    if(data!="")
                                            alert(data);
                                    fn_buscar()
                            }
                    });
            }
}

function marcar(source) 
{
        checkboxes=document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
        for(i=0;i<checkboxes.length;i++) //recoremos todos los controles
        {
                if(checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
                {
                        checkboxes[i].checked=source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
                }
        }
}