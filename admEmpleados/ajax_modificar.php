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
if(empty($_POST['id']) || empty($_POST['dni']) || empty($_POST['nombre']) || empty($_POST['apellido'])|| empty($_POST['tipo_empleado'])){
        echo "Usted no a llenado todos los campos";
        exit;
}

/*modificar el registro*/
$descripcion = strtoupper($_POST['apellido'].", ".$_POST['nombre']." - ".$_POST['dni']);
$sql ="UPDATE empleados SET descripcion='".$descripcion."', apellido='".strtoupper($_POST['apellido'])."', nombre='".strtoupper($_POST['nombre'])."', dni='".$_POST['dni']."', tipo_empleado_id='".$_POST['tipo_empleado']."' where id=".$_POST['id'];

$conexion = new ConsultaBD();
$conexion->Conectar();

if(!$conexion->executeQuery($sql))
        echo "Error al insertar el plato:\n$sql";
$conexion->Close();    

exit;
?>