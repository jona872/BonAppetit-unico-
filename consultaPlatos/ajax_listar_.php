<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';
require_once "../ClasesBasicas/PHPPaging.lib.php";
require_once "../ClasesBasicas/Basico.php";

header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

$conexion = new ConsultaBD();
$conexion->Conectar();
$paging = new PHPPaging;
$sql = "SELECT factura_detalles.id as id_det,  TIMEDIFF(factura_detalles.`fecha_entrega`,factura_detalles.`fecha_cocina`) AS dif, tipo_recetas.pasa_cocina, factura_maestros.id, IF(factura_detalles.`fecha_alta` IS NULL, factura_maestros.`fecha_y_hora`, factura_detalles.`fecha_alta`) as fecha_alta, factura_detalles.`cantidad`,  
   DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%d-%m-%Y') AS fecha_alta_, 
IF(factura_detalles.`fecha_alta` IS NULL, DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s'), DATE_FORMAT(factura_detalles.`fecha_alta`,'%H:%i:%s')) AS hora_alta,    
IF(factura_detalles.`fecha_cocina` IS NULL, DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s'), DATE_FORMAT(factura_detalles.`fecha_cocina`,'%H:%i:%s')) AS hora_cocina,    
IF(factura_detalles.`fecha_entrega` IS NULL, DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s'), DATE_FORMAT(factura_detalles.`fecha_entrega`,'%H:%i:%s')) AS hora_entrega,    
factura_detalles.`observacion`,factura_detalles.`observaciontiempo`,factura_detalles.`fecha_cocina`, factura_detalles.`fecha_entrega`, factura_maestros.`mesa_nro`,factura_maestros.`cantidad_comensales`, empleados.`descripcion` as empleado, factura_detalles.`id_tipo_plato`, tipo_recetas.`descripcion` as tipo_plato, factura_detalles.descripcion, tipo_recetas.`tiempo_preparacion` FROM factura_maestros
INNER JOIN factura_detalles ON factura_maestros.`id`=factura_detalles.`factura_maestro_id`
LEFT JOIN empleados ON factura_maestros.`empleado_id`=empleados.`id`
LEFT JOIN tipo_recetas ON tipo_recetas.`id`=factura_detalles.`id_tipo_plato` ";
if (isset($_GET['criterio_buscar']))
        $sql .= " WHERE factura_detalles.descripcion like '%".fn_filtro(substr(utf8_decode($_GET['criterio_buscar']), 0, 16))."%'";

if(isset($_GET['intervalo']) && ($_GET['intervalo']==0)) {

    if (isset($_GET['fechaDesde']) && ($_GET['fechaDesde']<>'')) {
            $dia=substr($_GET['fechaDesde'],0,2);                
            $mes=substr($_GET['fechaDesde'],3,2);        
            $anio=substr($_GET['fechaDesde'],6,4);
            if (isset($_GET['horaDesde']) && ($_GET['horaDesde']<>'')) {
                $hora=substr($_GET['horaDesde'],0,2);                
                $min=substr($_GET['horaDesde'],3,2);        
            } else {
                $hora = '00';
                $min = '00';
            }
            $seg='00';
            $sql .= "  AND IF(factura_detalles.`fecha_alta` IS NULL, DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%Y-%m-%d %H:%i:%s'), DATE_FORMAT(factura_detalles.`fecha_alta`,'%Y-%m-%d %H:%i:%s')) >= DATE_FORMAT('".$anio."-".$mes."-".$dia." ".$hora.":".$min.":".$seg."', '%Y-%m-%d %H:%i:%s')";
    }
    
    if (isset($_GET['fechaHasta']) && ($_GET['fechaHasta']<>'')) {
            $dia=substr($_GET['fechaHasta'],0,2);                
            $mes=substr($_GET['fechaHasta'],3,2);        
            $anio=substr($_GET['fechaHasta'],6,4);
            if (isset($_GET['horaHasta']) && ($_GET['horaHasta']<>'')) {
                $hora=substr($_GET['horaHasta'],0,2);                
                $min=substr($_GET['horaHasta'],3,2);        
            } else  {
                $hora = '00';
                $min = '00';
            }
            $seg='00';
            $sql .= "  AND IF(factura_detalles.`fecha_alta` IS NULL, DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%Y-%m-%d %H:%i:%s'), DATE_FORMAT(factura_detalles.`fecha_alta`,'%Y-%m-%d %H:%i:%s')) <= DATE_FORMAT('".$anio."-".$mes."-".$dia." ".$hora.":".$min.":".$seg."', '%Y-%m-%d %H:%i:%s')";
    }

} else {
    if(isset($_GET['intervalo']) && ($_GET['intervalo']==1)) {
        if (isset($_GET['fechaDesde']) && ($_GET['fechaDesde']<>'')) {
                $dia=substr($_GET['fechaDesde'],0,2);                
                $mes=substr($_GET['fechaDesde'],3,2);        
                $anio=substr($_GET['fechaDesde'],6,4);
                $sql .= "  AND IF(factura_detalles.`fecha_alta` IS NULL, DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%Y-%m-%d'), DATE_FORMAT(factura_detalles.`fecha_alta`,'%Y-%m-%d')) >= DATE_FORMAT('".$anio."-".$mes."-".$dia."', '%Y-%m-%d')";
        }
        if (isset($_GET['horaDesde']) && ($_GET['horaDesde']<>'')) {
                $hora=substr($_GET['horaDesde'],0,2);                
                $min=substr($_GET['horaDesde'],3,2);        
                $seg='00';
                $sql .= "  AND IF(factura_detalles.`fecha_alta` IS NULL, DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s'), DATE_FORMAT(factura_detalles.`fecha_alta`,'%H:%i:%s')) >= TIME_FORMAT('".$hora.":".$min.":".$seg."', '%H:%i:%s')";
        }
        if (isset($_GET['fechaHasta']) && ($_GET['fechaHasta']<>'')) {
                $dia=substr($_GET['fechaHasta'],0,2);                
                $mes=substr($_GET['fechaHasta'],3,2);        
                $anio=substr($_GET['fechaHasta'],6,4);
                $sql .= "  AND IF(factura_detalles.`fecha_alta` IS NULL, DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%Y-%m-%d'), DATE_FORMAT(factura_detalles.`fecha_alta`,'%Y-%m-%d')) <= DATE_FORMAT('".$anio."-".$mes."-".$dia."', '%Y-%m-%d')";
        }
        if (isset($_GET['horaHasta']) && ($_GET['horaHasta']<>'')) {
                $hora=substr($_GET['horaHasta'],0,2);                
                $min=substr($_GET['horaHasta'],3,2);        
                $seg='00';
                $sql .= "  AND IF(factura_detalles.`fecha_alta` IS NULL, DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s'), DATE_FORMAT(factura_detalles.`fecha_alta`,'%H:%i:%s')) <= TIME_FORMAT('".$hora.":".$min.":".$seg."', '%H:%i:%s')";
        }
    }
}
if (isset($_GET['empleado']) && ($_GET['empleado']<>'')) {
        $sql .= "  AND empleados.id = ".$_GET['empleado_ID']."";
}
if (isset($_GET['tipo_receta']) && ($_GET['tipo_receta']<>'')) {
        $sql .= "  AND  tipo_recetas.`id`= ".$_GET['tipo_receta']."";
}
if (isset($_GET['tipo_estado']) && ($_GET['tipo_estado']<>'')) {
    $sql.=" AND TIMEDIFF(factura_detalles.`fecha_entrega`,factura_detalles.`fecha_cocina`) ".$_GET['tipo_estado']." TIME_FORMAT('00:'+tipo_recetas.`tiempo_preparacion`+':00','%H:%s:%i') ";     
    //$sql.=" AND TIMEDIFF(IF(factura_detalles.`fecha_entrega` IS NULL, DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s'), DATE_FORMAT(factura_detalles.`fecha_entrega`,'%H:%i:%s')),IF(factura_detalles.`fecha_cocina` IS NULL, DATE_FORMAT(factura_detalles.`fecha_alta`,'%H:%i:%s'), DATE_FORMAT(factura_detalles.`fecha_cocina`,'%H:%i:%s'))) ".$_GET['tipo_estado']." TIME_FORMAT('00:'+tipo_recetas.`tiempo_preparacion`+':00','%H:%s:%i')";
}
if (isset($_GET['criterio_ordenar_por']))
        $sql .= sprintf(" order by %s %s, factura_detalles.id ", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
else
        $sql .= " order by factura_detalles.id desc";

$paging->agregarConsulta($sql); 
$paging->div('div_listar');
$paging->modo('desarrollo'); 
if (isset($_GET['criterio_mostrar']))
        $paging->porPagina(fn_filtro((int)$_GET['criterio_mostrar']));
$paging->verPost(true);
$paging->mantenerVar("criterio_buscar", "criterio_ordenar_por", "criterio_orden", "criterio_mostrar","fechaDesde","horaDesde","fechaHasta","horaHasta","empleado_ID","empleado","tipo_receta","tipo_estado", "intervalo");
$paging->ejecutar();

function RestarHoras($horaini,$horafin)
{
	$horai=substr($horaini,0,2);
	$mini=substr($horaini,3,2);
	$segi=substr($horaini,6,2);

	$horaf=substr($horafin,0,2);
	$minf=substr($horafin,3,2);
	$segf=substr($horafin,6,2);

	$ini=((($horai*60)*60)+($mini*60)+$segi);
	$fin=((($horaf*60)*60)+($minf*60)+$segf);

	$dif=$fin-$ini;

	$difh=floor($dif/3600);
	$difm=floor(($dif-($difh*3600))/60);
	$difs=$dif-($difm*60)-($difh*3600);
	return date("H:i:s",mktime($difh,$difm,$difs));
}

?>
<div style="width: 1000px; ">
<table id="estados" class="header" style="width: 100%;">
  <tr style="text-align: left">       
            <td style="width: 80px">Fecha</td>
            <td style="width: 20px">Mesa</td>
            <td style="width: 20px">Comensales</td>
            <td>Mozo</td>
            <td>Tipo plato</td> 
            <td>Plato</td>              
            <td>Cantidad</td>
            <td>Obs. Entrega</td>      
            <td style="width: 20px">Tiempo preparación</td>
            <td style="width: 20px">Hora Pedido</td>
            <td style="width: 20px">Hora Cocina</td>
            <td style="width: 20px">Hora Entrega</td>                    
            <td>Tiempo excedido</td>                                    
        </tr>
    <?php
        $id_ant =0;
        while ($rs_inf = $paging->fetchResultado()){
            if($rs_inf['pasa_cocina']==1) {
                $tiempo_prep = date("H:i:s",mktime(00,$rs_inf['tiempo_preparacion'],00));
                $tiempo = RestarHoras($rs_inf['hora_cocina'],$rs_inf['hora_entrega']);               
                $id_ = $rs_inf['id'];
                $sql2 = "SELECT tipo_recetas.tiempo_preparacion, TIMEDIFF(factura_detalles.`fecha_entrega`,factura_detalles.`fecha_cocina`),factura_detalles.* FROM factura_detalles LEFT JOIN tipo_recetas ON tipo_recetas.`id`=factura_detalles.`id_tipo_plato` "
                        . "WHERE factura_maestro_id=".$rs_inf['id']." AND fecha_cocina = '".$rs_inf['fecha_cocina']."' AND factura_detalles.id<>".$rs_inf['id_det']." AND "
                        . "TIMEDIFF(factura_detalles.`fecha_entrega`,factura_detalles.`fecha_cocina`) > TIME_FORMAT('00:'+tipo_recetas.`tiempo_preparacion`+':00','%H:%s:%i') ";                                             
                $conexion->executeQuery($sql2);
                if($conexion->getNumRows()>0) {
                    $s=0;
                    while($inf = $conexion->getFetchArray()){
                	$cod=$inf["tiempo_preparacion"] ;
                        if($rs_inf['tiempo_preparacion']>$cod) {                            
                            $s=1;
                        }                                                
                    }
                    if($s==1) {
                     $ver_estado =RestarHoras($tiempo_prep,$tiempo); 
                    } else $ver_estado = "NO";                        
                }else {
                        $ver_estado = "NO";                        
                }
                
            } else {
                $tiempo = RestarHoras($rs_inf['hora_alta'],$rs_inf['hora_entrega']);         
                $ver_estado = "NO";            
            }
            
            //if($tiempo>$tiempo_prep) $ver_estado = RestarHoras($tiempo_prep,$tiempo); else $ver_estado = "NO";                        
                ?>
                
                    <?php if($rs_inf['id']<>$id_ant) {
                        ?>
                        <tr  id="tr_<?php echo $rs_inf['id']?>" style="background-color: #6FA7D1;text-align: left">
                        <td><?php echo $rs_inf['fecha_alta_']?></td>
                        <td style="text-align: right" ><?php echo $rs_inf['mesa_nro']; ?></td>
                        <td style="text-align: right" ><?php echo $rs_inf['cantidad_comensales']; ?></td>
                        <td><?php echo utf8_encode($rs_inf['empleado']); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        </tr>
                        <?php     
                    } ?>
                    <tr style="text-align: left" id="tr_<?php echo $rs_inf['id']?>">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo utf8_encode($rs_inf['tipo_plato']); ?></td>
                    <td><?php echo utf8_encode($rs_inf['descripcion']); ?></td>
                    <td><?php echo utf8_encode($rs_inf['cantidad']); ?></td>
                    <td><?php echo utf8_encode($rs_inf['observaciontiempo']); ?></td>
                    <td style="text-align: right" ><?php if($rs_inf['tiempo_preparacion']<>'') echo "00:".$rs_inf['tiempo_preparacion'].":00"; ?></td>
                    <td><?php echo $rs_inf['hora_alta']?></td>                        
                    <td><?php if($rs_inf['pasa_cocina']==1)  echo $rs_inf['hora_cocina']; else echo ""; ?></td>  
                    <td><?php echo $rs_inf['hora_entrega']?></td>                     
                    <td><?php echo $rs_inf['id_det'].$sql2.$ver_estado ?></td>                                    
                </tr>
            <?php                                   
            $id_ant=$rs_inf['id'];
           
        }
        ?>
    <tfoot style="text-align: center">
        <tr>
            <td colspan="13">
                <?php echo $paging->fetchNavegacion()."<br/>"; ?>
            </td>
        </tr>
    </tfoot>
</table><?php                
//-- Aqui MOSTRAMOS MAS DETALLADAMENTE EL PAGINADO
echo "<br/>Página: ".$paging->numEstaPagina()." de ".$paging->numTotalPaginas()."<br />
Mostrando: ".$paging->numRegistrosMostrados()." platos, del ".$paging->numPrimerRegistro()." al ".$paging->numUltimoRegistro()."<br />
De un total de: ".$paging->numTotalRegistros()."<br />";
?><br />           
</div>

