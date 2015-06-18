<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';

/*verificamos si las variables se envian*/
if(empty($_POST['item']) || empty($_POST['cantidad'])){
        echo "Debe ingresar los datos requeridos";
        exit;
}

$conexion = new ConsultaBD();
$conexion->Conectar();
mysql_query('BEGIN');

$sql = "SELECT precio FROM receta_maestros WHERE id=".$_POST['item'];
$conexion->executeQuery($sql);
$row = $conexion->getFetchObject();

$sql = "UPDATE pedido_maestros SET finalizado=9, total=total+".$row->precio." WHERE id=".$_POST['pedido_maestro_id'];
$conexion->executeQuery($sql);

$sql="INSERT INTO `pedido_detalles` (`descripcion`,`receta_maestro_id`,`pedido_maestro_id`,`cantidad`,`observaciones`,`precio_unitario`,`estado_id`,`timestamp_alta`,`empresa_id`,`usuario_id`)";
$sql.= " VALUES ('',".$_POST['item'].",".$_POST['pedido_maestro_id'].", ".$_POST['cantidad'].",'".$_POST['observaciones']."',".$row->precio.",'1',now(),1,".$_SESSION['usuario_id'].")";
$conexion->executeQuery($sql);
if($conexion->getResults()<>false) {
    mysql_query('COMMIT');
} else {
    mysql_query('ROLLBACK');
}
$conexion->Close();

exit;
?>