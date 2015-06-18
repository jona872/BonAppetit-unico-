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
$sql="UPDATE `pedido_detalles` SET `estado_id`='2', timestamp_entrega=now()";
$sql.=" WHERE id='".$_POST['ide_ped']."'";
$conexion->executeQuery($sql);
$conexion->Close();
exit;
?>