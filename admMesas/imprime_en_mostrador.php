<?php
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';

$maestro_id = $_POST['ide_ped'];

$conexion = new ConsultaBD();
$conexion->Conectar();
$consulta = "SELECT rm.tipo_receta_id, empleados.`apellido` AS empleado, pm.`cliente_id`, pm.mesa_nro, pm.empleado_id, rm.descripcion, SUM(pd.cantidad) AS cantidad, pd.precio_unitario, pd.`descuento`, pd.observaciones,
DATE_FORMAT(pm.`fecha_y_hora`,'%d-%m-%Y %h:%m') AS fecha, pm.`total`
FROM receta_maestros AS rm
INNER JOIN pedido_detalles AS pd ON pd.receta_maestro_id = rm.id
INNER JOIN pedido_maestros AS pm ON pd.pedido_maestro_id = pm.id
INNER JOIN empleados ON pm.`empleado_id`=empleados.`id`
WHERE pm.id = $maestro_id GROUP BY tipo_receta_id, descuento, precio_unitario, rm.descripcion";

$conexion->executeQuery($consulta);
$conexion->Close();
?>
<html>
    <!--<body onload="window.print();"  onUnload="self.opener.location='pedidos.php?p=<?//$maestro_id?>';">-->
    <body onload="window.print();"  onUnload="self.opener.location='index.php';">
<?php
if($conexion->getNumRows()>0) {
    $i = $total = 0;
    $conexion2 = new ConsultaBD();
    $conexion2->Conectar();
    while($r = $conexion->getFetchArray()){
        if($i==0) {
            $empleado    = $r['empleado'];        
            $cliente_id  = $r['cliente_id'];
            $fyh = $r['fecha'];
            $nro_mesa = $r['mesa_nro'];
            ?>

            
            <font size="22px;">
            <strong>Mesa: <?php echo $nro_mesa;?></strong>
            <br>
            </font>
            <?php             
        }
        
        $i=1;
        $descripcion    = $r['descripcion'];
        $cantidad       = $r['cantidad'];
        $precio_u       = $r['precio_unitario'];
        $descuento      = $r['descuento'];
        $observaciones  = $r['observaciones'];       
        $total = $total + ($cantidad*($precio_u-($descuento*$precio_u/100)));
        
        ?>
        <?php echo $cantidad." X $ ".$precio_u; if(($descuento<>'')&&($descuento<>0)) echo " (-".$descuento."%)";?>
        <br/>
        <strong><?php echo $descripcion." - $ ".$cantidad*($precio_u-($descuento*$precio_u/100));?></strong>
        <br>
        <?php
    }
    $conexion2->Close();
    ?>
    <h2>Total: $<?php echo $total;?></h2>    
    <br>
    _____________________________________<br>
    Documento no v&aacute;lido como factura.<br>
    Solicite su factura en la caja.
        </body>
    </html>
    <?php
}

$conexion->Conectar();
$sql_pm = "UPDATE pedido_maestros SET total = $total, finalizado='2', timestamp_ticket=now() WHERE id = $maestro_id";
$conexion->executeQuery($sql_pm);
$sql_pd = "UPDATE pedido_detalles SET estado_id = 2 WHERE pedido_maestro_id = $maestro_id";
$conexion->executeQuery($sql_pd);
$sql_pd2 = "UPDATE pedido_detalles SET timestamp_entrega = now() WHERE pedido_maestro_id = $maestro_id and timestamp_entrega is null";
$conexion->executeQuery($sql_pd2);
$conexion->Close();