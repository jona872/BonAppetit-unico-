<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';

$sql = "UPDATE empleados SET fecha_baja=now() where id=".$_POST['id'];
$conexion = new ConsultaBD();
$conexion->Conectar();
if(!$conexion->executeQuery($sql))
        echo "No es posible eliminar el empleado seleccionado".$sql;
$conexion->Close();
exit;
?>