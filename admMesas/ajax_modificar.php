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
if(empty($_POST['itemEditar']) || empty($_POST['myitemEditar'])){
        echo "Debe ingresar los datos requeridos";
        exit;
}

$conexion = new ConsultaBD();
$conexion->Conectar();
mysql_query('BEGIN');

$sql = "SELECT precio FROM receta_maestros WHERE id=".$_POST['itemEditar'];
$conexion->executeQuery($sql);
$row = $conexion->getFetchObject();

$sql = "SELECT cantidad FROM pedido_detalles WHERE id=".$_POST['ide_ped'];
$conexion->executeQuery($sql);
$row2 = $conexion->getFetchObject();

$sql="UPDATE `pedido_maestros` SET total = total-(".$row2->cantidad."*".$_POST['precio_ant'].")+(".$row2->cantidad."*".$row->precio.")";
$sql.=" WHERE id='".$_POST['ide_ped_maes']."'";
$conexion->executeQuery($sql);
    
$sql="UPDATE `pedido_detalles` SET `receta_maestro_id`=".$_POST['itemEditar'].", `precio_unitario`='".$row->precio."' ";
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