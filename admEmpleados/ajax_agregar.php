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
if(empty($_POST['dni']) || empty($_POST['nombre']) || empty($_POST['apellido'])|| empty($_POST['tipo_empleado'])){
        echo "Debe llenar todos los campos";
        exit;
}
$descripcion = strtoupper($_POST['apellido'].", ".$_POST['nombre']." - ".$_POST['dni']);
$sql = "INSERT INTO `empleados` (`descripcion`,`nombre`,`apellido`,`dni`,`tipo_empleado_id`) VALUES (";
$sql.= "'".$descripcion."', '".strtoupper($_POST['nombre'])."', '".strtoupper($_POST['apellido'])."', '".$_POST['dni']."', ".$_POST['tipo_empleado'].")";

$conexion = new ConsultaBD();
$conexion->Conectar();
mysql_query('BEGIN');

if(!$conexion->executeQuery($sql)) {
    echo "Error al insertar el empleado:\n$sql";
    mysql_query('ROLLBACK');
} else  mysql_query('COMMIT');

$conexion->Close();
exit;
?>