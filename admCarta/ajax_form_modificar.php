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

$sql = sprintf("select * from receta_maestros where id=%d",
		(int)$_POST['id']);
$conexion = new ConsultaBD();
$conexion->Conectar();
$conexion->executeQuery($sql);
$num_rs_per = $conexion->getNumRows();

if ($num_rs_per==0){
        echo "No existen platos con ese IDE";
        exit;
}
	
$rs_plato = $conexion->getFetchObject();
$conexion->Close();
	
?>
<center><h1>Modificación de Plato</h1>
<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_modificar();" method="post" id="frm_agregar">
    <input type="hidden" id="id" name="id" value="<?php echo $rs_plato->id; ?>" />
    <input type="hidden" id="codigo_hidden" name="codigo_hidden" value="<?php echo $rs_plato->codigo; ?>" />
    
    <table class="formulario">
        <tbody>
            
             <tr>
                <td>Código:</td>
                <td><input name="codigo_receta" type="text" id="codigo_receta" size="40" class="required" value="<?php echo utf8_encode($rs_plato->codigo); ?>"/></td>
            </tr>

            <tr>
                <td>Descripción:</td>
                <td><input name="descripcion" type="text" id="descripcion" size="40" class="required" value="<?php echo utf8_encode($rs_plato->descripcion); ?>"/></td>
            </tr>
            <tr>
                <td>Precio:</td>
                <td><input name="precio" type="text" id="precio" size="10" class="required" value="<?php echo $rs_plato->precio; ?>"/></td>
            </tr>            
            <tr>
                <td>Tipo Plato:</td>
                <td>
                    <select name="tipo_receta" ide="tipo_receta" class="required" >     
                        <option value=""></option>                        
                        <?php
                            $conexion = new ConsultaBD();
                            $conexion->Conectar();
                            $sql = "select * from tipo_recetas order by descripcion";
                            $conexion->executeQuery($sql);
                            while($rs_receta = $conexion->getFetchObject()){
                        ?>
                            <option value="<?php echo $rs_receta->id; ?>" <?php if($rs_plato->tipo_receta_id==$rs_receta->id) echo "selected"; ?>><?php echo $rs_receta->descripcion; ?></option>
                        <?php } ?>
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
                  
                codigo_receta:{
                    required: true,
                    
                
                },
             
				descripcion:{
					required: true				
				},
                    
                    precio:{
					required: true					
				},
                   tipo_receta:{
					required: true					
				}
			},
			messages: {
                codigo_receta: "<img src='../images/requerido.png'/>",
				descripcion: "<img src='../images/requerido.png'/>",
                                precio: "<img src='../images/requerido.png'/>",
                                tipo_receta: "<img src='../images/requerido.png'/>"
			},
			onkeyup: false,
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente modificar el plato?')
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