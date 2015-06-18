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
<center><h1>Nuevo Cliente</h1>
<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar();" method="post" id="frm_agregar">
    <table class="formulario">
        <tbody>
            <tr>
                <td>DNI:</td>
                <td><input name="dni" type="text" id="dni" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><input name="nombre" type="text" id="nombre" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Apellido:</td>
                <td><input name="apellido" type="text" id="apellido" size="40" class="required" /></td>
            </tr> 
            <tr>
                <td>Direccion:</td>
                <td><input name="direccion" type="text" id="direccion" size="40" class="required" /></td>
            </tr> 
             <tr>                      
                <td>Teléfono:</td>
                <td><input name="telefono" type="text" id="telefono" size="40" class="required" /></td>
            </tr>
            <tr>                      
                <td>Razon Social:</td>
                <td><input name="razon_social" type="text" id="razon_social" size="40" class="required" /></td>
            </tr>
            <tr>                      
                <td>Email:</td>
                <td><input name="email" type="text" id="email" size="40"/></td>
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
				nombre:{
					required: true					
				},
                apellido:{
					required: true					
				},
                                
                dni:{
					required: true					
				},
                direccion:{
					required: true					
				},
                telefono:{
					required: true					
				},
                razon_social:{
					required: true					
				}                
			},
			messages: {
                dni: "<img src='../images/requerido.png'/>",
				nombre: "<img src='../images/requerido.png'/>",
                apellido: "<img src='../images/requerido.png'/>",
                direccion: "<img src='../images/requerido.png'/>",
                telefono: "<img src='../images/requerido.png'/>",
                razon_social: "<img src='../images/requerido.png'/>"
                                
			},
			onkeyup: false,
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente guardar los datos?')
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