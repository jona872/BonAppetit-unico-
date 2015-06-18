<?php
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';

$maestro_id = $_POST['ide_ped'];
$conexion = new ConsultaBD();
$conexion->Conectar();
//$consulta = "SELECT SUM(pd.cantidad) AS cantidad, pd.id, rm.tipo_receta_id, pd.estado_id,tr.`descripcion` AS tipo_receta, emp.`apellido`,
//pm.mesa_nro, pm.empleado_id, rm.descripcion, pd.observaciones, pd.tiempo FROM receta_maestros AS rm
//INNER JOIN pedido_detalles AS pd ON pd.receta_maestro_id = rm.id 
//INNER JOIN pedido_maestros AS pm ON pd.pedido_maestro_id = pm.id 
//INNER JOIN tipo_recetas AS tr ON rm.`tipo_receta_id`=tr.`id`
//INNER JOIN empleados AS emp ON pm.`empleado_id`=emp.`id`
//WHERE pm.id = $maestro_id ";
$consulta = "SELECT SUM(pd.cantidad) AS cantidad, pd.id,
rm.tipo_receta_id, pd.estado_id,tr.`descripcion` AS tipo_receta, emp.`apellido`, pm.mesa_nro,
pm.empleado_id, rm.descripcion, pd.observaciones, pd.observaciontiempo, pd.tiempo, tr.tiempo_preparacion FROM pedido_detalles pd 
INNER JOIN receta_maestros AS rm ON pd.`receta_maestro_id`=rm.id
INNER JOIN pedido_maestros AS pm ON pd.`pedido_maestro_id`=pm.`id`
INNER JOIN tipo_recetas AS tr ON rm.`tipo_receta_id`=tr.`id`
INNER JOIN empleados AS emp ON pm.`empleado_id`=emp.`id`
WHERE pm.id = $maestro_id ";
if(isset($_POST['reimpresion'])) {
    $reimpresion = $_POST['reimpresion'];
    $consulta.=" AND (";
    foreach ($reimpresion as $value) {
        $consulta.=" pd.id=$value OR ";
    }
    $consulta.=" 1!=1)";
    $consulta.=" AND (pd.estado_id = 1 OR pd.estado_id = 3)";
} else $consulta.=" AND (pd.estado_id = 1)";
$consulta.=" AND pasa_cocina=1 group by rm.`tipo_receta_id`, rm.`descripcion`, descuento, precio_unitario, observaciones, observaciontiempo, tiempo ORDER BY tiempo, tipo_receta_id, rm.descripcion";

$conexion->executeQuery($consulta);
$conexion->Close();

?>
<html>
    <!--<body onload="window.print();"  onUnload="self.opener.location='pedidos.php?p=<?//$maestro_id?>';">-->
    <body onload="window.print();"  onUnload="self.opener.location='index.php';">
    _____________________________<br>    
    <?php
    $conexion2 = new ConsultaBD();
    $conexion2->Conectar();
    $ir = $tipo_receta_id_ant =  $tiempo_prep_ant =0;
  //  $tiempo_ant = 9;
    while($r = $conexion->getFetchArray()){
        if($ir==0) { ?>
            <font size="22px;">
                <strong>Mesa: <?php echo $r['mesa_nro'];?></strong>
                <br/>
            </font>
        <?php
        }
        
        $ir=1;
        $descripcion    = $r['descripcion'];
        $cantidad       = $r['cantidad'];
        $observaciones  = $r['observaciones'];
        $observaciontiempo = $r['observaciontiempo'];
        $tipo_receta_id = $r['tipo_receta_id'];
        $empleado_id    = $r['empleado_id'];
        $tipo_receta    = $r['tipo_receta'];
        $empleado       = $r['apellido'];        
        $tiempo         = $r['tiempo'];        
        $t_prep         = $r['tiempo_preparacion'];        
//    if($tiempo<>$tiempo_ant) {
//        echo "<br/>";
//        if($tiempo==0) {   echo "<strong>1er Plato</strong>"; }
//        if($tiempo==15) {   echo "<strong>2do Plato</strong>"; }
//        if($tiempo==99) {   echo "<strong>3er Plato</strong>"; }
//        $tiempo_ant = $tiempo;
//    }
    if($t_prep>$tiempo_prep_ant) {
        $tiempo_prep_ant = $t_prep;
    }
    if($tipo_receta_id<>$tipo_receta_id_ant) {
    ?>
        <br><strong><?php echo $tipo_receta;?></strong><br>
    <?php } ?>
    <strong><?php echo $cantidad;?></strong> - <?php echo $descripcion;?><br>
    <?php if($observaciones<>"") {   echo $observaciones."<br/>"; }?>
    <?php if($observaciontiempo<>"") {   echo $observaciontiempo."<br/>"; }?>
    
    <?php
    $tipo_receta_id_ant = $tipo_receta_id;
    }    
    $consulta2 = "UPDATE pedido_detalles, receta_maestros rm, tipo_recetas SET estado_id='3', timestamp_cocina=now(), demora_preparacion = ".$tiempo_prep_ant." 
        WHERE pedido_maestro_id = ".$maestro_id." AND estado_id = 1 AND pedido_detalles.`receta_maestro_id`=rm.`id` AND rm.tipo_receta_id=tipo_recetas.id
        AND tipo_recetas.`pasa_cocina`=1 ";
        if(isset($_POST['reimpresion'])) {
            $reimpresion = $_POST['reimpresion'];
            $consulta2.=" AND (";
            foreach ($reimpresion as $value) {
                $consulta2.=" pedido_detalles.id=$value OR ";
            }
            $consulta2.=" 1!=1)";            
        }         
    $conexion2->executeQuery($consulta2);
    $conexion2->Close();
    ?>
    <br>
    <strong>Mozo: <?php echo $empleado;?></strong><br>
    <strong>Fecha y hora: <?php echo date('d-m-Y H:i');?></strong><br>
    _____________________________

    </body>
</html>