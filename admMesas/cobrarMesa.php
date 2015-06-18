<?php
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';

$maestro_id = $_POST['ide_ped'];
$total = $_POST['total'];

$conexion = new ConsultaBD();
$conexion->Conectar();
mysql_query('BEGIN');

//Guardo todo en factura maestro y factura detalle para dejar constancia de la venta
$sql_fm = "INSERT INTO factura_maestros
(`descripcion`,`fecha_y_hora`,`fecha_y_hora_fin`,`cliente_id`,`total`,`subtotal`,`empleado_id`, `tipo_iva_id`,`empresa_id`,`usuario_id`,`cantidad_comensales`,`mesa_nro`,`ubicacion_id`)
SELECT CONCAT('VENTA DE COMIDA EN SALON - ',fecha_y_hora), fecha_y_hora, now(), cliente_id, ".$total.",'0.00', empleado_id ,'2','1',".$_SESSION['usuario_id'].", `cantidad_de_comensales`, `mesa_nro`, `ubicacion_id` FROM pedido_maestros WHERE id=".$maestro_id;
$conexion->executeQuery($sql_fm);

if($conexion->getResults()<>false) {
    mysql_query('COMMIT');
} else {
    die('Consulta no válida1: ' . mysql_error());
    mysql_query('ROLLBACK');
}

$conexion->executeQuery("SELECT @@identity AS id");
$row_id = $conexion->getFetchRow();
$pm_id = trim($row_id[0]);

// guardo el id de la facturacion generada en los pedidos
$sql_pm = "UPDATE pedido_maestros SET total = $total, finalizado='1', timestamp_finalizado=now(), factura_maestro_id=$pm_id WHERE id = $maestro_id";
$conexion->executeQuery($sql_pm);

if($conexion->getResults()<>false) {
    mysql_query('COMMIT');
} else {
    mysql_query('ROLLBACK');
    die('Consulta no válida2: ' . mysql_error());
}

$sql_pd = "UPDATE pedido_detalles SET estado_id = 2 WHERE pedido_maestro_id = $maestro_id";
$conexion->executeQuery($sql_pd);

if($conexion->getResults()<>false) {
    mysql_query('COMMIT');
} else {
    die('Consulta no válida3: ' . mysql_error());
    mysql_query('ROLLBACK');
}

$sql_pd2 = "UPDATE pedido_detalles SET timestamp_entrega = now() WHERE pedido_maestro_id = $maestro_id and timestamp_entrega is null";
$conexion->executeQuery($sql_pd2);

if($conexion->getResults()<>false) {
    mysql_query('COMMIT');
} else {
    die('Consulta no válida4: ' . mysql_error());
    mysql_query('ROLLBACK');
}


//Inserto los detalles en la factura_detalles.
//$sql_fd = "INSERT INTO `factura_detalles`(`descripcion`,`factura_maestro_id`,`cantidad`,`precio_unitario`,`empresa_id`,`usuario_id`,`fecha_alta`,`fecha_cocina`,`fecha_entrega`,`id_tipo_plato`)
//SELECT receta_maestros.`descripcion`, ".$pm_id.", pedido_detalles.`cantidad`, pedido_detalles.`precio_unitario`, 1,".$_SESSION['usuario_id'].", timestamp_alta, timestamp_cocina,timestamp_entrega,tipo_receta_id FROM pedido_detalles 
//INNER JOIN receta_maestros ON pedido_detalles.`receta_maestro_id`=receta_maestros.id
//WHERE pedido_maestro_id =".$maestro_id;
$sql_fd = "INSERT INTO `factura_detalles`(`descripcion`,`factura_maestro_id`,`cantidad`,`precio_unitario`,`observacion`,`observaciontiempo`,`empresa_id`,`usuario_id`,`fecha_alta`,`fecha_cocina`,`fecha_entrega`,`demora_preparacion`,`id_tipo_plato`)
            SELECT receta_maestros.`descripcion`, ".$pm_id.", pedido_detalles.`cantidad`, pedido_detalles.`precio_unitario`,pedido_detalles.`observaciones`,pedido_detalles.`observaciontiempo`, 1,".$_SESSION['usuario_id'].", timestamp_alta, timestamp_cocina,timestamp_entrega,demora_preparacion,tipo_receta_id FROM pedido_detalles 
            INNER JOIN receta_maestros ON pedido_detalles.`receta_maestro_id`=receta_maestros.id
            WHERE pedido_maestro_id =".$maestro_id; 
$conexion->executeQuery($sql_fd);



if($conexion->getResults()<>false) {
    mysql_query('COMMIT');
} else {
    die('Consulta no válida5: ' . mysql_error());
    mysql_query('ROLLBACK');
}
$conexion->Close();
Header("Location: index.php")

?>