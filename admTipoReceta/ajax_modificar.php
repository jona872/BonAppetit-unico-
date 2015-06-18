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
if(empty($_POST['id']) || empty($_POST['descripcion']) ){
        echo "Usted no a llenado todos los campos";
        exit;
}

/*modificar el registro*/
$sql ="UPDATE tipo_recetas SET descripcion='".strtoupper(utf8_decode($_POST['descripcion']))."', tiempo_preparacion='".$_POST['tiempo']."', pasa_cocina='".$_POST['cocina']."' where id=".$_POST['id'];

$conexion = new ConsultaBD();
$conexion->Conectar();

if(!$conexion->executeQuery($sql))
        echo "Error al insertar el tipo de plato:\n$sql";
$conexion->Close();    

exit;
?>