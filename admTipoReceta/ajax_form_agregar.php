<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';
?>
<center><h1>Nuevo Tipo de Plato</h1>
<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar();" method="post" id="frm_agregar">
    <table class="formulario">
        <tbody>
            <tr>
                <td>Descripción:</td>
                <td><input name="descripcion" type="text" id="descripcion" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Tiempo:</td>
                <td><input name="tiempo" type="text" id="tiempo" size="10" class="required" /></td>
            </tr>
            <tr>
                <td>Cocina:</td>
                <td>
                    <select name="cocina" ide="cocina" class="required">     
                        <option value="1">SI</option>                        
                        <option value="0">NO</option>                                                
                    </select>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td colspan="2" style="text-align: right;">
                    <input name="agregar" type="submit" id="agregar" value="Agregar" />
                    <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" />
                </td>
            </tr>
        </tfoot>
    </table>
    <br/><br/>
</form>
</center>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$("#frm_agregar").validate({
			rules:{
				descripcion:{
					required: true,
					remote: "ajax_verificar_usu_per.php"
				},
                                tiempo:{
					required: true					
				}
			},
			messages: {
				descripcion: "<img src='../images/requerido.png'/>",
                                tiempo: "<img src='../images/requerido.png'/>"                               
			},
			onkeyup: false,
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente agregar este nuevo tipo de  plato?')
				if (respuesta)
					form.submit();
			}
		});
	});
	
	function fn_agregar(){
		var str = $("#frm_agregar").serialize();
		$.ajax({
			url: 'ajax_agregar.php',
			data: str,
			type: 'post',
			success: function(data){
				if(data != "")
					alert(data);
				fn_cerrar();
				fn_buscar();
			}
		});
	};
</script>