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
$sql = "SELECT pedido_maestro_id,precio_unitario FROM pedido_detalles WHERE id=".$_POST['ide_ped'];
$conexion->executeQuery($sql);
$row = $conexion->getFetchObject();
$sql = "UPDATE pedido_maestros SET finalizado=9, total=total+".$row->precio_unitario." WHERE id=".$row->pedido_maestro_id;
$conexion->executeQuery($sql);
$sql="UPDATE `pedido_detalles` SET `cantidad`=`cantidad`+1, timestamp_alta=now()";
$sql.=" WHERE id=".$_POST['ide_ped'];
$conexion->executeQuery($sql);
if($conexion->getResults()<>false) {
    mysql_query('COMMIT');
} else {
    mysql_query('ROLLBACK');
}
$conexion->Close();
exit;
?>