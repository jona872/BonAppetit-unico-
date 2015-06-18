<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';
include_once '../ClasesBasicas/basico.php';

header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

$conexion = new ConsultaBD();
$conexion->Conectar();
$sql="SELECT pedido_maestros.`id`, empleados.descripcion AS empleado, ubicacion.`descripcion` AS ubicacion, pedido_maestros.`mesa_nro`, 
pedido_maestros.`cantidad_de_comensales`, DATE_FORMAT(pedido_maestros.`fecha_y_hora`,'%d-%m-%Y') AS fecha, DATE_FORMAT(pedido_maestros.`fecha_y_hora`,'%H:%i') AS hora,
DATE_FORMAT(pedido_maestros.`timestamp_finalizado`,'%d-%m-%Y') AS fecha_cierre, DATE_FORMAT(pedido_maestros.`timestamp_finalizado`,'%H:%i') AS hora_cierre,
pedido_maestros.`total`, pedido_maestros.`finalizado`
FROM pedido_maestros 
INNER JOIN ubicacion ON pedido_maestros.`ubicacion_id`=ubicacion.`id`
INNER JOIN empleados ON pedido_maestros.`empleado_id`=empleados.`id`";
if($_SESSION['usuario_nivel']==2) {
    $sql.=" WHERE (pedido_maestros.usuario_id=".$_SESSION['usuario_id']." or empleados.id=".$_SESSION['empleado_id'].")";
    if (isset($_GET['criterio_buscar'])) {
        $ver = $_GET['criterio_buscar'];
        if($ver<>'')   
            $sql.=" AND pedido_maestros.mesa_nro=".mysql_real_escape_string(substr(utf8_decode($_GET['criterio_buscar']), 0, 16));
    }
} else {    
    if (isset($_GET['criterio_buscar'])) {
        $ver = $_GET['criterio_buscar'];
        if($ver<>'')
            $sql.=" WHERE pedido_maestros.mesa_nro=".mysql_real_escape_string(substr(utf8_decode($_GET['criterio_buscar']), 0, 16));
    }
}
if (isset($_GET['criterio_ordenar_por']))
    $sql .= sprintf(" order by %s %s", mysql_real_escape_string($_GET['criterio_ordenar_por']), mysql_real_escape_string($_GET['criterio_orden']));
else
    $sql.=" ORDER BY fecha_y_hora DESC";

$conexion->executeQuery($sql);
$conexion->Close();
if ($conexion->getNumRows()<>0) {
?>
 
<div style="width: 1000px; text-align: left">
<form action="index.php" method="post" name="limpiar_mesa" id="limpiar_mesa" >
<div style="float: right;">                    
    <?php if(($_SESSION['usuario_nivel']==1)||($_SESSION['usuario_nivel']==2)) {?>
        <input type="submit" name="submit" class="" value="&nbsp;&nbsp;&nbsp;Limpiar Mesas&nbsp;&nbsp;&nbsp;" tabindex="1"/>            
    <?php } ?>                
</div>   
<!--<center> -->
<table id="estados" class="header" style="width: 100%;">
        <tr>       
            <td>Mozo</td>
            <td>Nro. Mesa</td>
            <td>Ubicaci&oacute;n</td>
            <td style="width: 90px">Comensales&nbsp;&nbsp;<img src="../img/edit.gif" /></td>
            <td style="width: 80px">Total</td>
            <td style="width: 70px">Apertura<br/>Fecha y Hora</td> 
            <td style="width: 70px">Cierre<br/>Fecha y Hora</td>             
            <td style="width: 80px">Estado</td>            
            <td>Acciones</td>     
            <?php if(($_SESSION['usuario_nivel']==1)||($_SESSION['usuario_nivel']==2)) {?>
            <td style="text-align:center"><input type="checkbox" onclick="marcar(this);" /></td>
            <?php } ?>
        </tr>    
    <?php
        $estados = array(
                        "1"=>"Cerrada",
			"0"=>"Abierta",
			"9"=>"Abierta",
			"2"=>"Abierta"			
                        
        );        
        while ($row = $conexion->getFetchObject()) {                
                ?>
                <tr>
                    <td style="text-align: left; "><?php echo utf8_encode($row->empleado)?></td>
                    <td><?php echo $row->mesa_nro ?></td>
                    <td><?php echo utf8_encode($row->ubicacion)?></td>
                    <td><div class="text" style="display: inline" id="cantidad_de_comensales-<?php echo $row->id ?>"><?php echo $row->cantidad_de_comensales; ?></div></td>                         
                    <td><?="$ ".$row->total?></td>     
                    <td><?=$row->fecha."<br/>".$row->hora?></td>          
                    <td><?=$row->fecha_cierre."<br/>".$row->hora_cierre?></td>          
                    <td><?php if($row->finalizado<>1) {
                        echo $estados[$row->finalizado];
                        } else {?>
                        <div class="select" id="finalizado-<?php echo $row->id ?>"><?php echo $estados[$row->finalizado]?>&nbsp;&nbsp;<img src="../img/reload.gif" /></div>
                        <?php } ?>
                    </td>                                
                    <td>
                        <?php if(($row->finalizado==0)){    // mesa abierta sin pedidos ?>
                            <a href="javascript: fn_eliminar(<?=$row->id?>);"><img src="../img/borrar.gif" /></a>   
                        <?php } 
                        if($row->finalizado!=1){    // mesa abierta con pedidos ?>
                            <a href="../admMesas/pedidos.php?p=<?=$row->id?>"><img src="../img/comanda.gif" /></a>                        
                            <a href="../editarMesa/index.php?p=<?=$row->id?>"><img src="../img/reload.gif" /></a>
                        <?php }                         
                        if($row->finalizado==1){    // mesa cerrada ?>
                            <a href="../admMesas/pedidos.php?p=<?=$row->id?>&c=1"><img src="../img/comanda.gif" /></a>                        
                        <?php } ?>
                    </td>  
                    <?php if(($_SESSION['usuario_nivel']==1)||($_SESSION['usuario_nivel']==2)) {?>
                   <td><?php if($row->finalizado!=0) { ?>
                       <input type="checkbox" name="limpiar[]" value="<?=$row->id?>"  /></td>
                   <?php } } ?>
                </tr>
        <?php            
            }             
            ?>
</table>
</form>
</div>

<!--</center>-->
<script language="javascript" type="text/javascript">
    $(document).ready(function(){       
        $('.text').editable('ajax_estados.php', { 
            type     : 'text'           
        });
        
        $('.select').editable('ajax_estados.php', { 
            data   : " {'1':'Cerrada','9':'Abierta'}",
            type   : 'select'
            
        });
        
    });    
    
		
</script>
<?php
} else {
    echo "<center><br/>No existen datos para mostrar</center>";
}
?>
