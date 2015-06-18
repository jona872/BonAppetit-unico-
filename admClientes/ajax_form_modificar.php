<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';

if(empty($_POST['id'])){
        echo "Por favor no altere el fuente";
        exit;
}

$sql = sprintf("select * from clientes where id=%d",
		(int)$_POST['id']);
$conexion = new ConsultaBD();
$conexion->Conectar();
$conexion->executeQuery($sql);
$num_rs_per = $conexion->getNumRows();

if ($num_rs_per==0){
        echo "No existen Clientes con ese ID";
        exit;
}
	
$rs_cliente = $conexion->getFetchObject();
$conexion->Close();
	
?>
<center><h1>Modificación de Cliente</h1>
<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_modificar();" method="post" id="frm_agregar">
    <input type="hidden" id="id" name="id" value="<?php echo $rs_cliente->id; ?>" />
     <input type="hidden" id="fecha_baja" name="fecha_baja" value="<?php echo $rs_cliente->fecha_baja; ?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>DNI:</td>
                <td><input name="dni" type="text" id="dni" size="40" class="required" value="<?php echo $rs_cliente->dni; ?>"/></td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><input name="nombre" type="text" id="nombre" size="40" class="required" value="<?php echo $rs_cliente->nombre; ?>"/></td>
            </tr>           
            <tr>
                <td>Apellido:</td>
                <td><input name="apellido" type="text" id="apellido" size="40" class="required" value="<?php echo $rs_cliente->apellido; ?>"/>                     </td>
            </tr>
            <tr>
                <td>Dirección:</td>
                <td><input name="direccion" type="text" id="direccion" size="40" class="required" value="<?php echo $rs_cliente->direccion; ?>"/>                     </td>
            </tr>
            <tr>
                <td>Teléfono:</td>
                <td><input name="telefono" type="text" id="telefono" size="40" class="required" value="<?php echo $rs_cliente->telefono; ?>"/>                     </td>
            </tr>
            <tr>
                <td>Razon Social:</td>
                <td><input name="razon_social" type="text" id="razon_social" size="40" class="required" value="<?php echo $rs_cliente->razon_social; ?>"/>                     </td>
            </tr>
            <tr>
                <td>email:</td>
                <td><input name="email" type="text" id="email" size="40" class="required" value="<?php echo $rs_cliente->email; ?>"/>                                 </td>
            </tr>
            <tr>
                <td>Estado:</td>
                <td>
                    <select name="estado" id="estado">
  <option value="1" <?php if( $rs_cliente->estado == 1) echo " selected" ?>>Activo</option>
  <option value="0" <?php if( $rs_cliente->estado == 0) echo " selected" ?>>Baja</option>
                    </select>
                </td>
            </tr>
                
        </tbody>
        <tfoot>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td colspan="2" style="text-align: right;">
                    <input name="agregar" type="submit" id="agregar" value="Modificar" />
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
                telefono:{
					required: true					
				},
                razon_social:{
					required: true					
				},
                                direccion:{
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
				var respuesta = confirm('\xBFDesea realmente modificar los datos?')
				if (respuesta)
					form.submit();
			}
		});
	});
	
	function fn_modificar(){
		var str = $("#frm_agregar").serialize();
		$.ajax({
			url: 'ajax_modificar.php',
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