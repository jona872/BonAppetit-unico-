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
<center><h1>Nuevo Empleado</h1>
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
                <td>Tipo Empleado:</td>
                <td>
                    <select name="tipo_empleado" ide="tipo_empleado" class="required">     
                        <option value=""></option>                        
                        <?php
                            $conexion = new ConsultaBD();
                            $conexion->Conectar();
                            $sql = "select * from tipo_empleados order by descripcion";
                            $conexion->executeQuery($sql);
                            while($rs_receta = $conexion->getFetchObject()){
                        ?>
                            <option value="<?php echo $rs_receta->id; ?>"><?php echo $rs_receta->descripcion; ?></option>
                        <?php } ?>
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
				nombre:{
					required: true					
				},
                                apellido:{
					required: true					
				},
                                
                                dni:{
					required: true					
				},
                                tipo_empleado:{
					required: true					
				}
			},
			messages: {
                                dni: "<img src='../images/requerido.png'/>",
				nombre: "<img src='../images/requerido.png'/>",
                                apellido: "<img src='../images/requerido.png'/>",
                                tipo_empleado: "<img src='../images/requerido.png'/>"
                                
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