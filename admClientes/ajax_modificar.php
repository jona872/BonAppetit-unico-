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
if(empty($_POST['id']) || empty($_POST['dni']) || empty($_POST['nombre']) || empty($_POST['apellido'])|| empty($_POST['razon_social'])|| empty($_POST['telefono'])|| empty($_POST['direccion'])){
        echo "Usted no a llenado todos los campos";
        exit;
}

if ($_POST['estado'] == 1) {$sql2 = " , estado = 1, fecha_baja = null ";} // si cambia de 0 a 1, borro la fecha
else if (($_POST['estado'] == 0) && !(empty($_POST['fecha_baja']))) {$sql2 = "";} //no cambio nada en la parte de estado
else if (($_POST['estado'] == 0) && (empty($_POST['fecha_baja']))) {$sql2 = " ,estado=0 ,fecha_baja=now() ";} //cambia de 1 a 0, entonces cambio el estado y asigno fecha;
                                
                                
                                
/*modificar el registro*/
$descripcion = strtoupper($_POST['apellido'].", ".$_POST['nombre']." - ".$_POST['dni']);
$sql ="UPDATE clientes SET descripcion='".$descripcion."', apellido='".strtoupper($_POST['apellido'])."', nombre='".strtoupper($_POST['nombre'])."', dni='".$_POST['dni']."', razon_social='".$_POST['razon_social']."', direccion='".$_POST['direccion']."', telefono='".$_POST['telefono']."'";
$where = " where id=".$_POST['id'];

$sqlfinal = $sql . $sql2 . $where;

$conexion = new ConsultaBD();
$conexion->Conectar();

if(!$conexion->executeQuery($sqlfinal))
        echo "Error al Modificar el Cliente:\n$sqlfinal";
$conexion->Close();    

exit;
?>