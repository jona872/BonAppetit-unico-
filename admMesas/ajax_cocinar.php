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

$sql_ma = "SELECT pedido_maestro_id FROM pedido_detalles WHERE id=".$_POST['ide_ped'];
$conexion->executeQuery($sql_ma);
$row_id = $conexion->getFetchRow();  

$sql = "UPDATE pedido_maestros SET finalizado=9 WHERE id=".$row_id[0];
$conexion->executeQuery($sql);

$sql="UPDATE `pedido_detalles` SET `estado_id`='3', timestamp_entrega='(NULL)'";
$sql.=" WHERE id='".$_POST['ide_ped']."'";
$conexion->executeQuery($sql);

if($conexion->getResults()<>false) {
    mysql_query('COMMIT');
} else {
    mysql_query('ROLLBACK');
}
$conexion->Close();
exit;
?>