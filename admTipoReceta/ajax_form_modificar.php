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

$sql = sprintf("select * from tipo_recetas where id=%d",
		(int)$_POST['id']);
$conexion = new ConsultaBD();
$conexion->Conectar();
$conexion->executeQuery($sql);
$num_rs_per = $conexion->getNumRows();

if ($num_rs_per==0){
        echo "No existen tipos de platos con ese IDE";
        exit;
}
	
$rs_plato = $conexion->getFetchObject();
$conexion->Close();
	
?>
<center><h1>Modificación de Tipo de Plato</h1>
<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_modificar();" method="post" id="frm_agregar">
    <input type="hidden" id="id" name="id" value="<?php echo $rs_plato->id; ?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>Descripción:</td>
                <td><input name="descripcion" type="text" id="descripcion" size="40" class="required" value="<?php echo utf8_encode($rs_plato->descripcion); ?>"/></td>
            </tr>
            <tr>
                <td>Tiempo:</td>
                <td><input name="tiempo" type="text" id="tiempo" size="10" class="required" value="<?php echo $rs_plato->tiempo_preparacion; ?>"/></td>
            </tr>  
            <tr>
                <td>Cocina:</td>
                <td>
                    <select name="cocina" ide="cocina" class="required" >                                                     
                        <option value="1" <?php if($rs_plato->pasa_cocina==1) echo "selected"; ?>>SI</option>                        
                        <option value="0" <?php if($rs_plato->pasa_cocina==0) echo "selected"; ?>>NO</option>                        
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
				descripcion:{
					required: true				
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
				var respuesta = confirm('\xBFDesea realmente modificar el tipo de plato?')
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