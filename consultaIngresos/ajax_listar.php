<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once ('../usuarios/aut_verifica.inc.php');



require_once ('../ClasesBasicas/ConsultaBD.php');


require_once ('../ClasesBasicas/PHPPaging.lib.php');

include_once ('../ClasesBasicas/Basico.php');



header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

$conexion = new ConsultaBD();
$conexion->Conectar();
$paging = new PHPPaging;
$sql = "SELECT DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%d-%m-%Y') as fecha_alta, DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s') as hora_alta, mesa_nro, empleados.`descripcion` as empleado,
    cantidad_comensales, ROUND(total/cantidad_comensales,2) AS promedio, total, ubicacion.`descripcion` as ubicacion
FROM factura_maestros 
LEFT JOIN empleados ON empleados.id= factura_maestros.`empleado_id`
LEFT JOIN ubicacion ON ubicacion.id= factura_maestros.`ubicacion_id` WHERE 1=1";
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
                $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%Y-%m-%d %H:%i:%s') >= DATE_FORMAT('".$anio."-".$mes."-".$dia." ".$hora.":".$min.":".$seg."', '%Y-%m-%d %H:%i:%s')";
        }   
        if (isset($_GET['fechaHasta']) && ($_GET['fechaHasta']<>'')) {
                $dia=substr($_GET['fechaHasta'],0,2);                
                $mes=substr($_GET['fechaHasta'],3,2);        
                $anio=substr($_GET['fechaHasta'],6,4);
                if (isset($_GET['horaHasta']) && ($_GET['horaHasta']<>'')) {
                    $hora=substr($_GET['horaHasta'],0,2);                
                    $min=substr($_GET['horaHasta'],3,2);        
                } else {
                     $hora = '00';
                     $min = '00';
                }
                $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%Y-%m-%d %H:%i:%s') <= DATE_FORMAT('".$anio."-".$mes."-".$dia." ".$hora.":".$min.":".$seg."', '%Y-%m-%d %H:%i:%s')";
        }

} else {
  if(isset($_GET['intervalo']) && ($_GET['intervalo']==1)) {
        if (isset($_GET['fechaDesde']) && ($_GET['fechaDesde']<>'')) {
                $dia=substr($_GET['fechaDesde'],0,2);                
                $mes=substr($_GET['fechaDesde'],3,2);        
                $anio=substr($_GET['fechaDesde'],6,4);
                $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%Y-%m-%d') >= DATE_FORMAT('".$anio."-".$mes."-".$dia."', '%Y-%m-%d')";
        }
          if (isset($_GET['fechaHasta']) && ($_GET['fechaHasta']<>'')) {
                $dia=substr($_GET['fechaHasta'],0,2);                
                $mes=substr($_GET['fechaHasta'],3,2);        
                $anio=substr($_GET['fechaHasta'],6,4);
                $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%Y-%m-%d') <= DATE_FORMAT('".$anio."-".$mes."-".$dia."', '%Y-%m-%d')";
        }
        if (isset($_GET['horaDesde']) && ($_GET['horaDesde']<>'')) {
                $hora=substr($_GET['horaDesde'],0,2);
                $min=substr($_GET['horaDesde'],3,2);
                $seg='00';

             if (isset($_GET['nocturno'])){
                $sql .= "  AND ((DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s') >= TIME_FORMAT('".$hora.":".$min.":".$seg."', '%H:%i:%s')";
                  $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s') < TIME_FORMAT('24:00:00', '%H:%i:%s'))";
             }
            else{

             $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s') >= TIME_FORMAT('".$hora.":".$min.":".$seg."', '%H:%i:%s')";


             }
        }

        if (isset($_GET['horaHasta']) && ($_GET['horaHasta']<>'')) {
                $hora=substr($_GET['horaHasta'],0,2);                
                $min=substr($_GET['horaHasta'],3,2);        
                $seg='00';
            if (isset($_GET['nocturno'])){
               //////////inicio de mi quiery para el turno nocturna
         $sql .= "  OR (DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s') <= TIME_FORMAT('".$hora.":".$min.":".$seg."', '%H:%i:%s')";
                 $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s') > TIME_FORMAT('00:00:00', '%H:%i:%s')))";

     //////////fin mi quiery para el turno nocturna
            }else {
                
                 $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s') <= TIME_FORMAT('".$hora.":".$min.":".$seg."', '%H:%i:%s')";

            }

        }
    }
}
if (isset($_GET['empleado']) && ($_GET['empleado']<>'')) {
        $sql .= "  AND empleados.id = ".$_GET['empleado_ID']."";
}
if (isset($_GET['ubicacion']) && ($_GET['ubicacion']<>'')) {
        $sql .= "  AND  ubicacion.`id`= ".$_GET['ubicacion']."";
}
if (isset($_GET['gastado_de']) && ($_GET['gastado_de']<>'')) {
        $sql.=" AND total >=".$_GET['gastado_de'];
}
if (isset($_GET['gastado_hasta']) && ($_GET['gastado_hasta']<>'')) {
        $sql.=" AND total <=".$_GET['gastado_hasta'];
}
if (isset($_GET['criterio_ordenar_por']))
       $sql .= sprintf(" order by %s %s ",  mysql_real_escape_string($_GET['criterio_ordenar_por']),  mysql_real_escape_string($_GET['criterio_orden']));
else
        $sql .= " order by factura_maestros.id desc";

$paging->agregarConsulta($sql); 
$paging->div('div_listar');
$paging->modo('desarrollo'); 
if (isset($_GET['criterio_mostrar']))
        $paging->porPagina( mysql_real_escape_string((int)$_GET['criterio_mostrar']));
$paging->verPost(true);
$paging->mantenerVar("criterio_buscar", "criterio_ordenar_por", "criterio_orden", "criterio_mostrar","nocturno","fechaDesde","horaDesde","fechaHasta","horaHasta","empleado_ID","empleado","ubicacion","gastado_de","gastado_hasta", "intervalo");
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
            <td style="width: 20px">Hora</td>
            <td style="width: 20px">Mesa</td>
            <td >Ubicación</td>
            <td style="width: 20px">Comensales</td>
            <td>Mozo</td>
            <td>Prom. Ing. x Comensal</td> 
            <td>Total</td>                          
        </tr>
    <?php

        while ($rs_inf = $paging->fetchResultado()){
                
                        ?>         
                    <tr style="text-align: left" id="tr_<?php echo $rs_inf['id']?>">
                    <td><?php echo $rs_inf['fecha_alta']?></td>
                    <td><?php echo $rs_inf['hora_alta']?></td>
                    <td style="text-align: right" ><?php echo $rs_inf['mesa_nro']; ?></td>
                    <td><?php echo utf8_encode($rs_inf['ubicacion']); ?></td>
                    <td style="text-align: right" ><?php echo $rs_inf['cantidad_comensales']; ?></td>
                    <td><?php echo utf8_encode($rs_inf['empleado']); ?></td>                                        
                    <td style="text-align: right"><?php echo $rs_inf['promedio']; ?></td>                        
                    <td style="text-align: right"><?php echo $rs_inf['total']; ?></td>                                                                      
                </tr>
            <?php
        }
        ?>
    <tfoot style="text-align: center">
        <tr>
            <td colspan="11">
                <?php echo $paging->fetchNavegacion()."<br/>"; ?>
            </td>
        </tr>
    </tfoot>
</table><?php                
$conexion = new ConsultaBD();
$conexion->Conectar();
$sql = "SELECT SUM(factura_maestros.cantidad_comensales) as comensales, COUNT(DISTINCT factura_maestros.empleado_id) as mozos, SUM(factura_maestros.total) as total_gral FROM factura_maestros
LEFT JOIN empleados ON empleados.id= factura_maestros.`empleado_id`
LEFT JOIN ubicacion ON ubicacion.id= factura_maestros.`ubicacion_id` WHERE 1=1";
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
                $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%Y-%m-%d %H:%i:%s') >= DATE_FORMAT('".$anio."-".$mes."-".$dia." ".$hora.":".$min.":".$seg."', '%Y-%m-%d %H:%i:%s')";
        }   
        if (isset($_GET['fechaHasta']) && ($_GET['fechaHasta']<>'')) {
                $dia=substr($_GET['fechaHasta'],0,2);                
                $mes=substr($_GET['fechaHasta'],3,2);        
                $anio=substr($_GET['fechaHasta'],6,4);
                if (isset($_GET['horaHasta']) && ($_GET['horaHasta']<>'')) {
                    $hora=substr($_GET['horaHasta'],0,2);                
                    $min=substr($_GET['horaHasta'],3,2);        
                } else {
                     $hora = '00';
                     $min = '00';
                }
                $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%Y-%m-%d %H:%i:%s') <= DATE_FORMAT('".$anio."-".$mes."-".$dia." ".$hora.":".$min.":".$seg."', '%Y-%m-%d %H:%i:%s')";
        }

} else {

    if(isset($_GET['intervalo']) && ($_GET['intervalo']==1)) {
        if (isset($_GET['fechaDesde']) && ($_GET['fechaDesde']<>'')) {
                $dia=substr($_GET['fechaDesde'],0,2);                
                $mes=substr($_GET['fechaDesde'],3,2);        
                $anio=substr($_GET['fechaDesde'],6,4);
                $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%Y-%m-%d') >= DATE_FORMAT('".$anio."-".$mes."-".$dia."', '%Y-%m-%d')";
        }
          if (isset($_GET['fechaHasta']) && ($_GET['fechaHasta']<>'')) {
                $dia=substr($_GET['fechaHasta'],0,2);                
                $mes=substr($_GET['fechaHasta'],3,2);        
                $anio=substr($_GET['fechaHasta'],6,4);
                $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%Y-%m-%d') <= DATE_FORMAT('".$anio."-".$mes."-".$dia."', '%Y-%m-%d')";
        }
        if (isset($_GET['horaDesde']) && ($_GET['horaDesde']<>'')) {
                $hora=substr($_GET['horaDesde'],0,2);
                $min=substr($_GET['horaDesde'],3,2);
                $seg='00';

             if (isset($_GET['nocturno'])){
                $sql .= "  AND ((DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s') >= TIME_FORMAT('".$hora.":".$min.":".$seg."', '%H:%i:%s')";
                  $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s') < TIME_FORMAT('24:00:00', '%H:%i:%s'))";
             }
            else{

             $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s') >= TIME_FORMAT('".$hora.":".$min.":".$seg."', '%H:%i:%s')";


             }
        }

        if (isset($_GET['horaHasta']) && ($_GET['horaHasta']<>'')) {
                $hora=substr($_GET['horaHasta'],0,2);                
                $min=substr($_GET['horaHasta'],3,2);        
                $seg='00';
            if (isset($_GET['nocturno'])){
               //////////inicio de mi quiery para el turno nocturna
         $sql .= "  OR (DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s') <= TIME_FORMAT('".$hora.":".$min.":".$seg."', '%H:%i:%s')";
                 $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s') > TIME_FORMAT('00:00:00', '%H:%i:%s')))";

     //////////fin mi quiery para el turno nocturna
            }else {
                
                 $sql .= "  AND DATE_FORMAT(factura_maestros.`fecha_y_hora`,'%H:%i:%s') <= TIME_FORMAT('".$hora.":".$min.":".$seg."', '%H:%i:%s')";

            }

        }
   }
}
if (isset($_GET['empleado']) && ($_GET['empleado']<>'')) {
        $sql .= "  AND empleados.id = ".$_GET['empleado_ID']."";
}
if (isset($_GET['ubicacion']) && ($_GET['ubicacion']<>'')) {
        $sql .= "  AND  ubicacion.`id`= ".$_GET['ubicacion']."";
}
if (isset($_GET['gastado_de']) && ($_GET['gastado_de']<>'')) {
        $sql.=" AND total >=".$_GET['gastado_de'];
}
if (isset($_GET['gastado_hasta']) && ($_GET['gastado_hasta']<>'')) {
        $sql.=" AND total <=".$_GET['gastado_hasta'];
}
//echo($sql);
$conexion->executeQuery($sql);
$rs_receta = $conexion->getFetchObject();

//-- Aqui MOSTRAMOS MAS DETALLADAMENTE EL PAGINADO
echo "<br/>Página: ".$paging->numEstaPagina()." de ".$paging->numTotalPaginas()."<br />
Mostrando: ".$paging->numRegistrosMostrados()." mesas, del ".$paging->numPrimerRegistro()." al ".$paging->numUltimoRegistro()."<br />
De un total de: ".$paging->numTotalRegistros()." mesas<br />";
echo "Cantidad total de comensales atendidos: ".$rs_receta->comensales."<br/>";   
if(($paging->numTotalRegistros()<>0)&&($paging->numTotalRegistros()<>''))
	echo "Promedio de cantidad de comensales por mesa: ".round($rs_receta->comensales/$paging->numTotalRegistros(),0)."<br/>";     
else
	echo "Promedio de cantidad de comensales por mesa: 0<br/>";     
echo "Cantidad de mozos: ".$rs_receta->mozos."<br/>";     
if(($rs_receta->comensales<>0)&&($rs_receta->comensales<>''))
	echo "Promedio de ingreso por comensal: $".round($rs_receta->total_gral/$rs_receta->comensales,2)."<br/>";     
else 
	echo "Promedio de ingreso por comensal: $ 0<br/>";     
echo "Total: $".$rs_receta->total_gral."<br/>";



?><br />           
</div>
