<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';

if(empty($_POST['ide_ped'])){
        echo "Ha ocurrido un error intentado mostrar la pantalla de modificacion de datos";
        exit;
}
        
$conexion = new ConsultaBD();
$conexion->Conectar();
$sql="select pedido_detalles.pedido_maestro_id, receta_maestros.descripcion, pedido_detalles.cantidad, pedido_detalles.precio_unitario from pedido_detalles 
inner join receta_maestros on receta_maestros.id=pedido_detalles.receta_maestro_id    
where pedido_detalles.id=".$_POST['ide_ped'];
$conexion->executeQuery($sql);
$row = $conexion->getFetchObject();
$conexion->Close();
?>   
    <h1>Modificaci&oacute;n del item</h1>
    <p><?php echo $row->descripcion; ?></p>
    <form action="javascript: fn_modificar();" method="post" id="frm_ped"  >
        <input type="hidden" id="ide_ped" name="ide_ped" value="<?=$_POST['ide_ped']?>" />
        <input type="hidden" id="ide_ped_maes" name="ide_ped_maes" value="<?=$row->pedido_maestro_id;?>" />
        <input type="hidden" id="precio_ant" name="precio_ant" value="<?=$row->precio_unitario;?>" />
        <table >
            <tbody>
                <tr>
                    <td>por el siguiente:</td>
                </tr>
                <tr>
                    <td>
                        <?php
                     
                        $conexion->Conectar();
            $sql = 'SELECT * FROM receta_maestros';                               
            $select =  $conexion->executeQuery($sql);            
            $conexion->Close();
            $dd='';
            $value= null;
            $field='itemEditar';
            $dd .= '<script type="text/javascript">
            $(function()
            {
                    // Updated script
                    var categories = $.map($("#s'.$field.' option"),function(e, i)
                    {
                    return e;
                    });

                    $("#my'.$field.'").autocomplete(categories,
                    {
                    matchContains : true,
                    formatItem : function(item) { return item.text; }
                    });
                    // Added to fill hidden field with option value
                    $("#my'.$field.'").result(function(event, item, formatted)
                    {
                    $("#'.$field.'").val(item.value);
                    }
            )});
            </script>';
            $dd .= '
            <input type="hidden" id="'.$field.'" name="'.$field.'" size="1" readonly="true"></input>
            <input type="text" id="my'.$field.'" name="my'.$field.'" size="50" >
                </input>'.'<select id="s'.$field.'" style="display: none">';
             while ($foreign = mysql_fetch_assoc($select)) {  
                        $dd .= "<option title=\"".$foreign['descripcion']."\"   value='".$foreign['id']."'";
                        if ($foreign['id'] == $value){ $dd .= ' selected';}
                        if (!empty($foreign['descripcion'])){
                                $dd .= '>'.utf8_encode($foreign['descripcion'])." - ".$foreign['codigo'].'</option>';
                        }else{
                                $dd .= '>'.$foreign['id'].'</option>';
                        }
            } 

            echo  $dd;
                
            
                
                ?>
<!--                    <input type="text" id="itemEditar" name="itemEditar" value="" onKeyUp="ajax_showOptionsItemEditar(this,'getItemEditarByLetters',event)" size="50" onFocus="this.style.color='green'" onBlur="this.style.color='#333333'" />*
                    <input type="hidden" id="itemEditar_hidden" name="itemEditar_ID" />-->
                    </td>
                </tr>            
            </tbody>            
            <tfoot>
                <tr>
                    <td colspan="2" align="right" style="padding-top: 10px;">
                        <input type="submit" name="modificar"  id="modificar" value="Modificar" class="button"/>
                        <input type="button" name="cancelar" id="cancelar" value="Cancelar" class="button" onclick="fn_cerrar();" />
                    </td>
                </tr>
            </tfoot>
        </table>
        <br/><br/><br/>
    </form>
    <?php

?>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$("#frm_ped").validate({
			submitHandler: function(form) {
					form.submit();
			}
		});
	});
	
	function fn_modificar(){
		var str = $("#frm_ped").serialize();
		$.ajax({
			url: 'ajax_modificar.php',
			data: str,
			type: 'post',
			success: function(data){
				if(data != "") {
					alert(data);
                                        itemEditar.focus();                                        
                                } else {
                                    fn_cerrar();
                                    fn_buscar(<?php echo $row->pedido_maestro_id; ?>);
                                }
			}
		});
	};
</script>