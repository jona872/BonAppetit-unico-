<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';

$conexion = new ConsultaBD();
$conexion->Conectar();
mysql_query('BEGIN');
$sql = "SELECT pedido_detalles.pedido_maestro_id, pedido_detalles.precio_unitario, tipo_recetas.id FROM pedido_detalles "
        . "INNER JOIN receta_maestros ON pedido_detalles.`receta_maestro_id`=receta_maestros.`id` "
        . "INNER JOIN tipo_recetas ON receta_maestros.`tipo_receta_id`=tipo_recetas.id "
        . "WHERE pedido_detalles.id=".$_POST['ide_ped'];

$conexion->executeQuery($sql);
$row = $conexion->getFetchObject();
$sql = "UPDATE pedido_maestros SET finalizado=9, total=total+".$row->precio_unitario." WHERE id=".$row->pedido_maestro_id;
$conexion->executeQuery($sql);
if($row->id==4) {
    $sql="INSERT INTO pedido_detalles 
    (             `descripcion`,
                 `receta_maestro_id`,
                 `pedido_maestro_id`,
                 `cantidad`,
                 `observaciones`,
                 `precio_unitario`,
                 `estado_id`,
                 `tiempo`,
                 `timestamp_entrega`,
                 `empresa_id`,
                 `usuario_id`)
                 SELECT `descripcion`,
      `receta_maestro_id`,
      `pedido_maestro_id`,
      1,
      `observaciones`,
      `precio_unitario`,
      2,
      `tiempo`,
      now(),
      `empresa_id`,
      `usuario_id`
     FROM pedido_detalles";
    $sql.=" WHERE id=".$_POST['ide_ped'];   
} else {    
    $sql="INSERT INTO pedido_detalles 
    (             `descripcion`,
                 `receta_maestro_id`,
                 `pedido_maestro_id`,
                 `cantidad`,
                 `observaciones`,
                 `precio_unitario`,
                 `estado_id`,
                 `tiempo`,
                 `empresa_id`,
                 `usuario_id`)
                 SELECT `descripcion`,
      `receta_maestro_id`,
      `pedido_maestro_id`,
      1,
      `observaciones`,
      `precio_unitario`,
      1,
      `tiempo`,
      `empresa_id`,
      `usuario_id`
     FROM pedido_detalles";
    $sql.=" WHERE id=".$_POST['ide_ped'];
}
$conexion->executeQuery($sql);
if($conexion->getResults()<>false) {
    mysql_query('COMMIT');
} else {
    mysql_query('ROLLBACK');
}
$conexion->Close();
exit;
?>