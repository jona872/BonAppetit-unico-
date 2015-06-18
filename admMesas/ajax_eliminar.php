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

$sql_ma = "SELECT pedido_maestro_id, precio_unitario FROM pedido_detalles WHERE id=".$_POST['ide_ped'];
$conexion->executeQuery($sql_ma);
$row_id = $conexion->getFetchRow();  

$sql="DELETE from `pedido_detalles` ";
$sql.=" WHERE id=".$_POST['ide_ped'];
$conexion->executeQuery($sql);

$sql_det = "SELECT pedido_maestro_id FROM pedido_detalles WHERE pedido_maestro_id=".$row_id[0];
$conexion->executeQuery($sql_det);

if($conexion->getNumRows()==0) { // si no tiene mas pedidos pongo la mesa en cero
    $sql="UPDATE `pedido_maestros` SET `finalizado`='0', total = '0.00', factura_maestro_id=null, timestamp_finalizado=NULL";
    $sql.=" WHERE id='".$row_id[0]."'";
    $conexion->executeQuery($sql);
} else {
    $sql="UPDATE `pedido_maestros` SET total = total-".$row_id[1];
    $sql.=" WHERE id='".$row_id[0]."'";
    $conexion->executeQuery($sql);
}

if($conexion->getResults()<>false) {
    mysql_query('COMMIT');
} else {
    mysql_query('ROLLBACK');
}
$conexion->Close();
exit;
?>