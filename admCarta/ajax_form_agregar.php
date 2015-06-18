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
<center><h1>Nuevo Plato</h1>
<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar();" method="post" id="frm_agregar">
    <table class="formulario">
        <tbody>
             <tr>
                <td>ID :</td>
                <td><input name="codigo_receta" type="text" id="codigo_receta" size="40" /></td>
            </tr>
           
            
              <tr>
                <td></td>
               <td><input type="checkbox" name="cbx_agregar" onclick="this.checked ? document.getElementById('codigo_receta').disabled = true :document.getElementById('codigo_receta').disabled = false;" > Agregar automaticamente</tr>
              </tr>
           
            <tr>
                <td>Descripción:</td>
                <td><input name="descripcion" type="text" id="descripcion" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Precio:</td>
                <td><input name="precio" type="text" id="precio" size="10" class="required" /></td>
            </tr>            
            <tr>
                <td>Tipo Plato:</td>
                <td>
                    <select name="tipo_receta" ide="tipo_receta" class="required">     
                        <option value=""></option>                        
                        <?php
                            $conexion = new ConsultaBD();
                            $conexion->Conectar();
                            $sql = "select * from tipo_recetas order by descripcion";
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
               
               codigo_receta:{
                    required: true,
                    remote: "ajax_verificar_codigo_receta.php"
                },
				descripcion:{
					required: true,
					remote: "ajax_verificar_usu_per.php"
				},
                                precio:{
					required: true					
				},
                                tipo_receta:{
					required: true					
				}
			},
			messages: {
               
				descripcion: "<img src='../images/requerido.png'/>",
                                precio: "<img src='../images/requerido.png'/>",
                                tipo_receta: "<img src='../images/requerido.png'/>"
			},
			onkeyup: false,
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente agregar este nuevo plato?')
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