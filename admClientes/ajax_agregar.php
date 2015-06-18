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
if(empty($_POST['dni']) || empty($_POST['nombre']) || empty($_POST['apellido'])|| empty($_POST['direccion'])|| empty($_POST['telefono'])|| empty($_POST['razon_social'])){
        echo "Debe llenar todos los campos Obligatorios";
        exit;
}
$descripcion = strtoupper($_POST['razon_social']." - ".$_POST['dni']);
$sql = "INSERT INTO `clientes` (`descripcion`,`nombre`,`apellido`,`direccion`,`telefono`,`email`,`dni`,`razon_social`,`estado`) VALUES (";
$sql.= "'".$descripcion."', '".strtoupper($_POST['nombre'])."', '".strtoupper($_POST['apellido'])."','".strtoupper($_POST['direccion'])."',
'".strtoupper($_POST['telefono'])."','".strtoupper($_POST['email'])."',
'".strtoupper($_POST['dni'])."','".strtoupper($_POST['razon_social'])."','1')";

$conexion = new ConsultaBD();
$conexion->Conectar();
mysql_query('BEGIN');

if(!$conexion->executeQuery($sql)) {
    echo "Error al insertar el Cliente:\n ". mysql_error();
    mysql_query('ROLLBACK');
} else  mysql_query('COMMIT');

$conexion->Close();
exit;
?>